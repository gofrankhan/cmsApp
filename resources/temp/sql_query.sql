INSERT INTO `tblclient` (`ID`, `AccountID`, `TaxID`, `CustomerType`, `FirstName`, `LastName`, `CompanyName`, `TelePhone`, `Mobilephnumber`, `Dob`, `pob`, `citizenship`, `Address1`, `Address2`, `City`, `Region`, `PostCode`, `CreationDate`) VALUES

INSERT INTO `customers` (`id`, `account_id`, `taxid`, `customertype`, `firstname`, `lastname`, `company`, `telephone`, `mobile`, `dateofbirth`, `pob`, `citizenship`, `addressline1`, `addressline2`, `city`, `region`, `postcode`, `created_at`) VALUES

INSERT INTO csnappdb.customers (`id` ,`account_id` ,`taxid` ,`customertype`, `firstname` ,`lastname` ,`company` ,`telephone`, `mobile` ,`dateofbirth` ,`pob` ,`citizenship`,`addressline1` ,`addressline2`, `city` ,`region` ,`postcode` ,`created_at`)  
SELECT `ID` ,`AccountID` ,`TaxID` ,`CustomerType`, `FirstName` ,`LastName` ,`CompanyName` ,`TelePhone`, `Mobilephnumber` ,`Dob` ,`pob` ,`citizenship`,`Address1` ,`Address2`, `City` ,`Region` ,`PostCode` ,`CreationDate` FROM cafpcpointdb.tblclient  

UPDATE customers
SET    username = 'gofran.khan';

INSERT INTO subscriptions (customer_id, is_subscribed, subscription_type, description, start_date, end_date)
SELECT id, 0, 'none' NULL, NULL, NULL
FROM customers;

invoices 
CREATE INDEX idx_invoices_status_userid ON invoices (status, user_id);
CREATE INDEX idx_invoices_fileid ON invoices (file_id DESC);
CREATE INDEX idx_invoices_customerid ON invoices (customer_id);
CREATE INDEX idx_invoices_serviceid ON invoices (service_id);

users
CREATE INDEX idx_users_shopname ON users (shop_name);
CREATE INDEX idx_users_id ON users (id);

customers
CREATE INDEX idx_customers_id ON customers (id);

services
CREATE INDEX idx_services_id ON services (id);

subscriptions
CREATE INDEX idx_subscriptions_customerid ON subscriptions (customer_id);
