INSERT INTO `customers` (`id`, `account_id`, `taxid`, `customertype`, `firstname`, `lastname`, `company`, `telephone`, `mobile`, 
`dateofbirth`, `pob`, `citizenship`, `addressline1`, `addressline2`, `city`, `region`, `postcode`, `created_at`) SELECT `ID`,
 `AccountID`, `TaxID`, `CustomerType`, `FirstName`, `LastName`, `CompanyName`, `TelePhone`, `Mobilephnumber`, `Dob`,
 `pob`, `citizenship`, `Address1`, `Address2`, `City`, `Region`, `PostCode`, `CreationDate` FROM cafpcpoint_clientmsdb_1.tblclient


INSERT INTO `invoices` (`id`, `customer_id`, `service_id`, `file_id`, `shop_name`, `created_at`)
SELECT `ID`, `Userid`, `ServiceId`, `BillingId`, `PostingBy`, `PostingDate` FROM cafpcpoint_clientmsdb_1.tblinvoice

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `user_type`,`mobile_no`,`created_at`)
SELECT `ID`, `AdminName`, `UserName`, `Email`, `Password`, `level`, `MobileNumber`, `AdminRegDate` FROM cafpcpoint_clientmsdb_1.tbladmin

INSERT INTO `services` (`id`, `category`, `service`, `price`, `created_at`)
SELECT `ID`, `ServiceCategory`, `ServiceName`, `ServicePrice`, `CreationDate` FROM cafpcpoint_clientmsdb_1.tblservices

INSERT INTO `categories` (`category`) SELECT DISTINCT `ServiceCategory` FROM cafpcpoint_clientmsdb_1.tblservices;

INSERT INTO `comments` (`id`, `file_id`, `username`, `comment`, `created_at`)
SELECT `id`, `invid`, `name`, `comment`, `comment_time` FROM cafpcpoint_clientmsdb_1.tbl_comments

INSERT INTO `attachments` (`id`, `file_id`, `file_name`, `upload_type` ,`username`)
SELECT `id`, `invid`, `file_name`, `upload_types`, `upload_by` FROM cafpcpoint_clientmsdb_1.tbl_files


NFRMDN77L63Z129Y


        $last_month_income = App\Models\Invoice::whereMonth(
               // 'updated_at', '=', Carbon::now()->subMonth()->month)->sum('price');