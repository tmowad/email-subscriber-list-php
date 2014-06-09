clear:
	rm -rf ~/public_html/email-subscriber-list

deploy: clear
	mkdir -p ~/public_html/email-subscriber-list
	cp *.php ~/public_html/email-subscriber-list

