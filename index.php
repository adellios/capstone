<head></head>
<body>
      

<?php
                //setting the target url for cURL
                $url = 'https://banner.slu.edu/ssbprd/bwckgens.p_proc_term_date';

                $headers = [
                        'Cache-Control: max-age=0',
                        'Upgrade-Insecure-Requests: 1',
                        'Content-Type: application/x-www-form-urlencoded'
                ];

                //setting variables for cURL including p_term (term)
                $postfields = 'p_calling_proc=bwckschd.p_disp_dyn_sched&p_term=';

                //initializing cURL and inputting variables to use in Banner search
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                //executing and ending cURL
                $server_output = curl_exec($ch);
                curl_close ($ch);

                //setting a pattern that will be used to identify the entirety of the html in the target page
                $pattern = '#<form.*</form>#s';
                $match = 0;
                preg_match( $pattern, $server_output, $match );
                $ourData = $match[0];
                
                //finding and changing the destination for the submit button to our results page called test.php
                $pattern_2 = '/bwckgens.p_proc_term_date/i';
                $replacement = 'test.php';
                $subject = $ourData;

                //removing search terms before Summer 2020
                $subject = preg_replace('/<option value="200/i', '', $subject);
                $subject = preg_replace('/<option value="201/i', '', $subject);
                $subject = preg_replace('/<option value="2020/i', '', $subject);
                
                //hard-coding the deletion of multiple / characters which are escape characters in preg, making it hard to modify them
               	$subject = preg_replace($pattern_2, $replacement, $subject);
                $subject[14] = ' ';
                $subject[21] = ' ';
                $subject = preg_replace('/ssbprd/i', '', $subject);
          
                //output results 
                echo $subject;

        ?>
</body>
