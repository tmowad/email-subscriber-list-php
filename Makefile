deploy: clear
	mkdir -p ~/public_html/email-subscriber-list
	cp *.php ~/public_html/email-subscriber-list
	cp -r vendor/ ~/public_html/email-subscriber-list

clear:
	rm -rf ~/public_html/email-subscriber-list


