<?php
/*
 * Copyright (c) 2011 Litle & Co.
*
* Permission is hereby granted, free of charge, to any person
* obtaining a copy of this software and associated documentation
* files (the "Software"), to deal in the Software without
* restriction, including without limitation the rights to use,
* copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the
* Software is furnished to do so, subject to the following
* conditions:
*
* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
* OTHER DEALINGS IN THE SOFTWARE.
*/
namespace litle\sdk;
require_once realpath(dirname(__FILE__)) . '/UrlMapper.php';
require_once realpath(dirname(__FILE__)) . '/PgpHelper.php';

function writeConfig($line,$handle)
{
    foreach ($line as $keys => $values) {
        fwrite($handle, $keys. '');
        if (is_array($values)) {
            foreach ($values as $key2 => $value2) {
                fwrite($handle,"['" . $key2 . "'] =" . $value2 .  PHP_EOL);
            }
        } else {
            fwrite($handle,' =' . $values);
            fwrite($handle, PHP_EOL);
        }
    }
}
function initialize()
{
    $line = array();
    $merchantArray = array();
    $handle = @fopen('./litle_SDK_config.ini', "w");
    if ($handle) {
        print "Welcome to Vantiv eCommerce PHP_SDK" . PHP_EOL;
        print "Please input your user name: ";
        $line['user'] = trim(fgets(STDIN));
        print "Please input your password: ";
        $line['password'] = "\"".trim(fgets(STDIN))."\"";
        print "Please input your merchantId: ";
        $line['currency_merchant_map ']['DEFAULT'] = trim(fgets(STDIN));
        print "Please choose Litle url from the following list (example: 'sandbox') or directly input another URL: \n" .
            "sandbox => https://www.testvantivcnp.com/sandbox/communicator/online \n" .
            "postlive => https://payments.vantivpostlive.com/vap/communicator/online \n" .
            "transact-postlive => https://transact.vantivpostlive.com/vap/communicator/online \n" .
            "production => https://payments.vantivcnp.com/vap/communicator/online \n" .
            "production-transact => https://transact.vantivcnp.com/vap/communicator/online \n" .
            "prelive => https://payments.vantivprelive.com/vap/communicator/online \n" .
            "transact-prelive => https://transact.vantivprelive.com/vap/communicator/online" . PHP_EOL;
        $url = UrlMapper::getUrl(trim(fgets(STDIN)));

        $line['url'] = $url;
        print "Please input the proxy, if no proxy hit enter key: ";
        $line['proxy'] = trim(fgets(STDIN));

        print "Batch processing saves files to disk. \n";
        print "Please input a directory to save these files. " .
            "If you are not using batch processing, you may hit enter. ";
        $dir = trim(fgets(STDIN));
        $line['batch_requests_path'] = $dir;
        $line['litle_requests_path'] = $dir;

        print "Please input your SFTP username. If you are not using SFTP, you may hit enter. ";
        $line['sftp_username'] = trim(fgets(STDIN));
        print "Please input your SFTP password. If you are not using SFTP, you may hit enter. ";
        $line['sftp_password'] = "\"".trim(fgets(STDIN))."\"";
        print "Please input the URL for batch processing. If you are not using batch processing, you may hit enter. ";
        $line['batch_url'] = trim(fgets(STDIN));
        print "Please input the port for stream batch delivery. " .
            "If you are not using stream batch delivery, you may hit enter. ";
        $line['tcp_port'] = trim(fgets(STDIN));
        print "Please input the timeout (in seconds) for stream batch delivery. " .
            "If you are not using stream batch delivery, you may hit enter. ";
        $line['tcp_timeout'] = trim(fgets(STDIN));
        # ssl should be usd by default
        $line['tcp_ssl'] = '1';
        $line['print_xml'] = '0';
        $line['deleteBatchFiles'] = 'false';
        print "Use PGP encryption for batch files? (y/n) (No encryption by default): ";
        $useEncryption = trim(fgets(STDIN));
        if(("y" == $useEncryption) || ("true" == $useEncryption) || ("yes" == $useEncryption)){
            $line['useEncryption'] = "true";
            print "Import Vantiv's public key to gpg key ring? (y/n): ";
            $import = trim(fgets(STDIN));
            if(("y" == $import) || ("yes" == $import) || ("true" == $import)) {
                print "Please input path to Vantiv's public key (for encryption of batch requests) :";
                $keyFile = trim(fgets(STDIN));
                $line['vantivPublicKeyID'] = PgpHelper::importKey($keyFile);
            }
            else{
                print "Please input key ID for Vantiv's public key (imported to your key ring) :";
                $line['vantivPublicKeyID'] = trim(fgets(STDIN));
            }
            print "Please input passphrase for decryption :";
            $line['gpgPassphrase'] = trim(fgets(STDIN));
        }
        else{
            $line['useEncryption'] = "false";
            $line['vantivPublicKeyID'] = "";
            $line['gpgPassphrase'] = "";
        }

        writeConfig($line,$handle);
        #default http timeout set to 500 ms
        fwrite($handle, "timeout =  500".  PHP_EOL);
        fwrite($handle, "reportGroup = Default Report Group".  PHP_EOL);
    }
    fclose($handle);
    print "The Vantiv eCommerce configuration file has been generated, " .
        "the file is located in the lib directory". PHP_EOL;
}

initialize();