INSERT INTO `tblclient` (`ID`, `AccountID`, `TaxID`, `CustomerType`, `FirstName`, `LastName`, `CompanyName`, `TelePhone`, `Mobilephnumber`, `Dob`, `pob`, `citizenship`, `Address1`, `Address2`, `City`, `Region`, `PostCode`, `CreationDate`) VALUES

INSERT INTO `customers` (`id`, `account_id`, `taxid`, `customertype`, `firstname`, `lastname`, `company`, `telephone`, `mobile`, `dateofbirth`, `pob`, `citizenship`, `addressline1`, `addressline2`, `city`, `region`, `postcode`, `created_at`) VALUES

INSERT INTO csnappdb.customers (`id` ,`account_id` ,`taxid` ,`customertype`, `firstname` ,`lastname` ,`company` ,`telephone`, `mobile` ,`dateofbirth` ,`pob` ,`citizenship`,`addressline1` ,`addressline2`, `city` ,`region` ,`postcode` ,`created_at`)  
SELECT `ID` ,`AccountID` ,`TaxID` ,`CustomerType`, `FirstName` ,`LastName` ,`CompanyName` ,`TelePhone`, `Mobilephnumber` ,`Dob` ,`pob` ,`citizenship`,`Address1` ,`Address2`, `City` ,`Region` ,`PostCode` ,`CreationDate` FROM cafpcpointdb.tblclient  

UPDATE customers
SET    username = 'gofran.khan';

INSERT INTO subscriptions (customer_id, is_subscribed, subscription_type, description, start_date, end_date)
SELECT id, 0, 'none' NULL, NULL, NULL
FROM customers;