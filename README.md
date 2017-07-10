# Sam_Project
Deriving a similarity score between two data flows in this project requires a three step process. First, the relevant parts of the flow are converted to text, where they can receive the necessary sorting and counting. Log files already in text form do not require this conversion. Second, irrelevant information present in a single line is removed from .pcap files by tcpdump. The final step includes the sorting, counting, and comparison of the values in the two groups. A collection of known origin is referred to as an exemplar. A collection of unknown origin is referred to as a suspect.

The GUI version requires two files index.php & combo.sh. It also requires a webserver (apache2) and PHP be installed. The php.ini requires modification to max_upload < 500MB. 

Installation for combo.sh-

mkdir /home/project2

chmod 777 /home/project2

cp project2/combo.sh /home/project2/combo.sh

chmod +x /home/project2/combo.sh

Installation for index.php-

mkdir /var/www/html/sam_project2

chmod 755 /var/www/html/sam_project2

cp sam_project2/index.php /var/www/html/sam_project2/index.php

After the two files are in place, browsing to localhost/sam_project2/index.php will create the other three directories and two file required to function properly. The install.tar.gz Tarball has the required files and folders. Running ./install.sh after extracting will put everything in place.

Once it functions properly, file and folder permission can/should be modified as best practice. 
The user interface is constructed of familiar textboxes, radio buttons, and submits buttons. Obtaining a score is a three step process; upload, evaluate, and score. The steps were separated to create maximum workflow clarity and minimize loads on the processor.

The first step is to upload a file into the system. The upload is the only action taken in this step. The user indicates if the file is a suspect (unknown) or exemplar (known) and if the file is .pcap or text. The file upload limitation was set in the php.ini at less than 500MB.

The second step is the evaluation, which is processed independent of the upload. The action is initiated with the unique identifier.

The third step is to obtain a similarity score. The process is case specific. The unique number added during upload is entered to initiate a comparison between the suspect and exemplar files for any single case. The similarity score is simply the Jaccard’s Similarity Coefficient of two lists. 

The terminal version of the tool is capable of providing the same similarity score as the GUI, but does not auto-score against the other samples in the system. It only requires the file jaccard.sh. It does write and then removes files during execution, so it might be best placed in the /home directory as well. For best results create a symbolic link to the /user/bin/ with -

 		ln –s /home/jaccard.sh /usr/bin/jaccard 
    
The syntax will then be - jaccard file1 -p file2 –p

The –p switch is replaced with –t in the event the file is text instead of .pcap. A whitespace separates the variables.
