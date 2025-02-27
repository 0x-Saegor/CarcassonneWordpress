<?php
/**
 * WPFormsDB csv
 */

if (!defined( 'ABSPATH')) exit;

class WPFormsDB_Export_CSV{

    /**
     * Download csv file
     * @param  String $filename
     * @return file
     */
    public function download_send_headers( $filename ) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");

    }
    /**
     * Convert array to csv format
     * @param  array  &$array
     * @return file csv format
     */
    public function array2csv(array &$array, $df){

        if (count($array) == 0) {
            return null;
        }

        $array_keys = array_keys($array);
        $heading    = array();
        $unwanted   = array('WPFormsDB_', 'your-');

        foreach ( $array_keys as $aKeys ) {
            $tmp       = str_replace( $unwanted, '', $aKeys );
            $heading[] = ucfirst( $tmp );
        }
        fputcsv( $df, $heading );

        foreach ( $array['form_id'] as $line => $form_id ) {
            $line_values = array();
            foreach($array_keys as $array_key ) {
                $val = isset( $array[ $array_key ][ $line ] ) ? $array[ $array_key ][ $line ] : '';
                $line_values[ $array_key ] = $val;
            }
            fputcsv($df, $line_values);
        }
    }
    /**
     * Download file
     * @return csv file
     */
    public function download_csv_file(){

        global $wpdb;
        $wpforms     = apply_filters( 'WPFormsDB_database', $wpdb );
        $table_name  = $wpforms->prefix.'wpforms_db';

        if( isset($_REQUEST['wpforms-csv']) && isset( $_REQUEST['nonce'] ) ){

            if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'dnonce')) {

                wp_die( 'Not Valid.. Download nonce..!! ' );
            }
            $fid         = (int)$_REQUEST['fid'];
            $heading_row = $wpforms->get_results("SELECT form_id, form_value, form_date FROM $table_name
                WHERE form_post_id = '$fid' ORDER BY form_id DESC LIMIT 1",OBJECT);

            $heading_row = reset( $heading_row );
            $heading_row = unserialize( $heading_row->form_value );
            $heading_key = array_keys( $heading_row );

            $total_rows  = $wpforms->get_var("SELECT COUNT(*) FROM $table_name WHERE form_post_id = '$fid' "); 
            $per_query    = 1000;
            $total_query  = ( $total_rows / $per_query );

            $this->download_send_headers( "WPFormsDB-" . gmdate("Y-m-d") . ".csv" );
            $df = fopen("php://output", 'w');
            ob_start();

            for( $p = 0; $p <= $total_query; $p++ ){

                $offset  = $p * $per_query;
                $results = $wpforms->get_results("SELECT form_id, form_value, form_date FROM $table_name
                WHERE form_post_id = '$fid' ORDER BY form_id DESC  LIMIT $offset, $per_query",OBJECT);
                
                $data  = array();
                $i     = 0;
                foreach ($results as $result) :
                    
                    $i++;
                    $data['form_id'][$i]    = $result->form_id;
                    $data['form_date'][$i]  = $result->form_date;
                    $resultTmp              = unserialize( $result->form_value );

                    foreach ($resultTmp as $key => $value):
                        if ( ! in_array( $key, $heading_key ) ) continue;
                        if ( is_array($value) ){

                            $data[$key][$i] = implode(', ', $value);
                            continue;
                        }

                        $data[$key][$i] = str_replace( array('&quot;','&#039;','&#047;','&#092;')
                        , array('"',"'",'/','\\'), $value );

                    endforeach;

                endforeach;

                echo $this->array2csv( $data, $df );

            }
            echo ob_get_clean();
            fclose( $df ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
            die();
        }
    }
}