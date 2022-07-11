<head></head>
<body>


<?php
                //setting the target url for cURL
                $url = 'https://banner.slu.edu/ssbprd/bwckschd.p_get_crse_unsec';

                $headers = [
                        'Cache-Control: max-age=0',
                        'Upgrade-Insecure-Requests: 1',
                        'Content-Type: application/x-www-form-urlencoded'
                ];

                //requesting from index.php the value of p_term which corresponds to term and year
                $p_term = $_REQUEST["p_term"];

                //error-catching in the case of user not selecting a term
                if ($p_term == "")
                        echo 'Please enter a valid term<br /><a href="index.php">Return to Previous</a>';

                //setting variables for cURL to use in Banner search
                //subject is selected with sel_subj, all of which are selected
                //attribute is selected with sel_attr which is currently set to AFR
                //attribute needs to be changed to the three letter code for Qualitative Research
               	$postfields = "term_in=$p_term&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_subj=AEP&sel_subj=ACCT&sel_subj=AENG&sel_subj=AES&sel_subj=AAM&sel_subj=ASTD&sel_subj=ANAT&sel_subj=ANTH&sel_subj=AA&sel_subj=ABA&sel_subj=AR&sel_subj=ART&sel_subj=ARTH&sel_subj=AS&sel_subj=MAT&sel_subj=ASCI&sel_subj=BSH&sel_subj=BIB&sel_subj=BCB&sel_subj=BIOL&sel_subj=BME&sel_subj=BLS&sel_subj=BBS&sel_subj=BSDP&sel_subj=BST&sel_subj=BREW&sel_subj=BIZ&sel_subj=BTM&sel_subj=CSO&sel_subj=CATH&sel_subj=CAD&sel_subj=CHEB&sel_subj=CHEM&sel_subj=CHIN&sel_subj=CVNG&sel_subj=CSDI&sel_subj=CMM&sel_subj=CMMK&sel_subj=CIS&sel_subj=CSCI&sel_subj=CCJ&sel_subj=CYBR&sel_subj=DANC&sel_subj=DATA&sel_subj=EAS&sel_subj=ECON&sel_subj=EDI&sel_subj=EDF&sel_subj=EDL&sel_subj=EPE&sel_subj=EDH&sel_subj=EDR&sel_subj=EDSP&sel_subj=ECE&sel_subj=EMGT&sel_subj=ENDG&sel_subj=ESCI&sel_subj=ENGL&sel_subj=ESL&sel_subj=EAP&sel_subj=EPI&sel_subj=FSTD&sel_subj=FIN&sel_subj=FPA&sel_subj=FSCI&sel_subj=FRSC&sel_subj=FREN&sel_subj=GIS&sel_subj=GR&sel_subj=GK&sel_subj=HCE&sel_subj=HDS&sel_subj=HIM&sel_subj=HMP&sel_subj=HSCI&sel_subj=HST&sel_subj=HIST&sel_subj=HR&sel_subj=HUM&sel_subj=SERV&sel_subj=IS&sel_subj=ITM&sel_subj=IAS&sel_subj=IEP&sel_subj=IB&sel_subj=ISTD&sel_subj=INTN&sel_subj=IPE&sel_subj=ITAL&sel_subj=LATN&sel_subj=LAW&sel_subj=LITD&sel_subj=MRI&sel_subj=MGT&sel_subj=MKT&sel_subj=MCH&sel_subj=MATH&sel_subj=MENG&sel_subj=MFT&sel_subj=MLS&sel_subj=MDVL&sel_subj=MB&sel_subj=MILS&sel_subj=MORL&sel_subj=MUSC&sel_subj=NEUR&sel_subj=NMT&sel_subj=NURS&sel_subj=DIET&sel_subj=OCS&sel_subj=OCTH&sel_subj=MOT&sel_subj=OPM&sel_subj=ORLD&sel_subj=ORTH&sel_subj=ORES&sel_subj=PSTH&sel_subj=PATH&sel_subj=PDED&sel_subj=PERI&sel_subj=PPY&sel_subj=PHIL&sel_subj=PLJ&sel_subj=PHL&sel_subj=DPT&sel_subj=PAED&sel_subj=PHYS&sel_subj=POLS&sel_subj=PG&sel_subj=PLS&sel_subj=PPHS&sel_subj=PST&sel_subj=PMGT&sel_subj=PSY&sel_subj=PSYK&sel_subj=PSP&sel_subj=PUBH&sel_subj=PHS&sel_subj=XRT&sel_subj=RUSS&sel_subj=SSI&sel_subj=SWRK&sel_subj=SOC&sel_subj=SPAN&sel_subj=SPR&sel_subj=STAT&sel_subj=INTL&sel_subj=STH&sel_subj=THR&sel_subj=THEO&sel_subj=UNIV&sel_subj=UPD&sel_subj=UPS&sel_subj=WGST&sel_crse=&sel_title=&sel_from_cred=&sel_to_cred=&sel_camp=%25&sel_levl=%25&sel_ptrm=%25&sel_instr=%25&sel_attr=AFR&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a";

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
                $pattern = '#<HTML.*</html>#s';
                $match = 0;
                preg_match( $pattern, $server_output, $match );
                $ourData = $match[0];

                //finding part of the html and changing it so that it can be redirected to the corresponding page with the course's detailed class information and catalog entry
                //preg match invokes escape characters for / and ' so we are changing every instance of href
                $pattern_3 = '/href="/i';
                $replacement_3 = 'href="https://banner.slu.edu';
                $subject = $ourData;

                //preserving the code attached to href for the "Return to Previous" button
                $subject = preg_replace('/href="j/i', 'placeholder', $subject);

                $subject = preg_replace($pattern_3, $replacement_3, $subject);

                //gets rid of header because we already have one on the google site
                //gets rid of HELP and EXIT buttons in top-right because unable to avoid invoking ' escape character
                $subject = preg_replace('/Class Schedule Listing/i', '', $subject);
                $subject = preg_replace('/>HELP</i', '><', $subject);
                $subject = preg_replace('/>EXIT</i', '><', $subject); 

                //changes links to all images to banner source
                $subject = preg_replace('/src="/i', 'src="https://banner.slu.edu', $subject);

                //preserving the code attached to href for the "Return to Previous" button
                $subject = preg_replace('/placeholder/i', 'href="j', $subject);

                //output results
                echo $subject;

        ?>
</body>
