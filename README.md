# Transactions

## Installing

### Prerequisites
	- php 5.6 or later
	- mysql

### Database setup

	CREATE TABLE transactions (  
		id INTEGER PRIMARY KEY autoincrement,  
		datetime DATETIME NOT NULL,  
		debtor VARCHAR(18) NOT NULL,  
		creditor VARCHAR(18) NOT NULL,  
		amount DECIMAL(12,2) NOT NULL,  
		description VARCHAR(255)  
	);  
