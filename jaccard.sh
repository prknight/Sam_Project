#!/bin/bash

##echo $1 $2 $3 $4
if [ $1 ] && [ $2 ] && [ $3 ] && [ $4 ]
then

	if [ $2 == "-p" ] && [ $4 == "-p" ]
	then
	#open tcpdump and capture x packets?
	tcpdump -nnq -r $1 > suspectsr
	tcpdump -nnq -r $3 > suspecter
	grep -oE "\b([0-9]{1,3}\.){3}[0-9]{1,3}\b" suspectsr | sort | uniq > suspectsi
	grep -oE "\b([0-9]{1,3}\.){3}[0-9]{1,3}\b" suspecter | sort | uniq > suspectei
	rm suspectsr
	rm suspecter
	fi

	if [ $2 == "-t" ] && [ $4 == "-t" ]
	then
	grep -oE "\b([0-9]{1,3}\.){3}[0-9]{1,3}\b" $1 | sort | uniq > suspectsi
	grep -oE "\b([0-9]{1,3}\.){3}[0-9]{1,3}\b" $3 | sort | uniq > suspectei
	fi

	if [ $2 == "-t" ] && [ $4 == "-p" ]
	then
	grep -oE "\b([0-9]{1,3}\.){3}[0-9]{1,3}\b" $1 | sort | uniq > suspectsi
	tcpdump -nnq -r $3 > suspecter
	grep -oE "\b([0-9]{1,3}\.){3}[0-9]{1,3}\b" suspecter | sort | uniq > suspectei
	rm suspecter
	fi

	if [ $2 == "-p" ] && [ $4 == "-t" ]
	then
	tcpdump -nnq -r $1 > suspectsr
	grep -oE "\b([0-9]{1,3}\.){3}[0-9]{1,3}\b" suspectsr | sort | uniq > suspectsi
	grep -oE "\b([0-9]{1,3}\.){3}[0-9]{1,3}\b" $3 | sort | uniq > suspectei
	rm suspectsr
	fi

	intersection=$(comm -12 <(sort suspectsi) <(sort suspectei) | uniq | wc -l)


	union=$(cat suspectsi suspectei | sort | uniq | wc -l)

	rm suspectsi
	rm suspectei

	##show the integers
	echo "$intersection/$union"

	##show the float score
	#bc <<< "scale=4;$intersection/$union"

	##put the score back into a variable
	score=$(bc <<< "scale=4;$intersection/$union")

	echo "Jaccard's Similarity Coefficient for $1 / $3 is "$score

else

echo The proper format is - jaccard file1 -p file2 -p

fi
