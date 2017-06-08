Running the acceptance tests requires a database. This page is a log of all changes made to the QA master database over time. Each time a new feature is enabled and configured, or new content is added, a database snapshot must be taken and uploaded to S3 and placed in the jr-qa-master bucket.

### Update Log
#### 4/26/2017
https://s3.amazonaws.com/jr-qa-master/qa-master_20170426_203459.sql.gz
* Enabled and configured the Springboard data warehouse module. It's currently pointing at the Acme database in mongo.
* Enabled and configured the fundraiser designations module. Added a sample designations form with 4 available funds at https://qa-master.qa.jacksonriverdev.com/content/designations-single-fund-group



#### 4/26/2017
https://s3.amazonaws.com/jr-qa-master/qa-master_20170426_174010.sql.gz
* Created a variety of different form configurations for client-side validation testing.
