INSERT INTO `customers` (`id`, `account_id`, `taxid`, `customertype`, `firstname`, `lastname`, `company`, `telephone`, `mobile`, 
`dateofbirth`, `pob`, `citizenship`, `addressline1`, `addressline2`, `city`, `region`, `postcode`, `created_at`) SELECT `ID`,
 `AccountID`, `TaxID`, `CustomerType`, `FirstName`, `LastName`, `CompanyName`, `TelePhone`, `Mobilephnumber`, `Dob`,
 `pob`, `citizenship`, `Address1`, `Address2`, `City`, `Region`, `PostCode`, `CreationDate` FROM cafpcpoint_clientmsdb.tblclient


INSERT INTO `invoices` (`id`, `customer_id`, `service_id`, `file_id`, `shop_name`, `created_at`)
SELECT `ID`, `Userid`, `ServiceId`, `BillingId`, `PostingBy`, `PostingDate` FROM cafpcpoint_clientmsdb.tblinvoice


NFRMDN77L63Z129Y


        $last_month_income = App\Models\Invoice::whereMonth(
               // 'updated_at', '=', Carbon::now()->subMonth()->month)->sum('price');