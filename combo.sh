#!/bin/bash

targets="/home/project2/suspect/$2"
targete="/home/project2/exemplar/$2"
dumps="/home/project2/$2/dump_suspect"
dumpe="/home/project2/$2/dump_exemplar"
suspects="/home/project2/$2/suspect.txt"
suspecte="/home/project2/$2/exemplar.txt"
sus="$3"
exem="$2"

##echo $1 $2 $3
##################################score1##################################
if [ $1 == "score1" ]

then
##Output Common to Both Columns
comm -12 <(sort $suspects) <(sort $susepcte) | uniq

##Count of addresses in both columns & pack the variable
intersection=$(comm -12 <(sort $suspects) <(sort $suspecte) | uniq | wc -l)

##Count of unique values in both & pack the variable
union=$(cat $suspects $suspecte | sort | uniq | wc -l)

##show the integers
echo "$intersection/$union"

##show the float score
bc <<< "scale=4;$intersection/$union"

##put the score back into a variable
score=$(bc <<< "scale=4;$intersection/$union")

echo "Jaccard's Similarity Coefficient for case $2 is "$score

fi
##############################print1#####################################
if [ $1 == "print1" ]

then

	if [ -f "$targets" ]

		then	tcpdump -nnq -r $targets > $dumps
		echo Suspect was checked 
		printf '\r '
		else
		echo No suspect was checked
		printf '\r '
	fi

	if [ -f "$targete" ]

		then tcpdump -nnq -r $targete > $dumpe
		echo Exemplar was checked
		printf '\r '
		else 
		echo No exemplar was checked
		printf '\r '
	fi

#collect IP addresses
grep -oE "\b([0-9]{1,3}\.){3}[0-9]{1,3}\b" $dumps | sort | uniq > $suspects
grep -oE "\b([0-9]{1,3}\.){3}[0-9]{1,3}\b" $dumpe | sort | uniq > $suspecte

#Web Review of IP addresses
grep -oE "\b([0-9]{1,3}\.){3}[0-9]{1,3}\b" $dumps | sort -n | uniq -c | sort -rn  | head -100 > /var/www/html/sam_project2/results/$2-suspect.txt
grep -oE "\b([0-9]{1,3}\.){3}[0-9]{1,3}\b" $dumpe | sort -n | uniq -c | sort -rn  | head -100 > /var/www/html/sam_project2/results/$2-exemplar.txt

fi

##############################auto1#############################
if [ $1 == "auto1" ]

then

##Count of addresses in both columns & pack the variable
intersection=$(comm -12 <(sort $sus) <(sort $exem) | uniq | wc -l)

##Count of unique values in both & pack the variable
##cat $suspects $suspecte | sort | uniq | wc -l
union=$(cat $sus $exem | sort | uniq | wc -l)

##show the integers
echo "$intersection/$union"

##show the float score
bc <<< "scale=4;$intersection/$union"

##put the score back into a variable
score=$(bc <<< "scale=4;$intersection/$union")

echo "Jaccard's Similarity is "$score

fi
