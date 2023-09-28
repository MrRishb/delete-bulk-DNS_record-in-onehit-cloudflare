In this script, we first fetch all DNS records for the specified zone and then iterate through them, sending DELETE requests individually for each record. Please replace 'your_api_token' and 'your_zone_id' with your actual API Token and Zone ID.

Please note that this script will delete DNS records one by one, so it may take some time if you have a large number of records to delete. Be cautious when running it, as the records will be permanently deleted.
