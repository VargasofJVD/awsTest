# awsTest
testing for how to integrate S3 and Cloudfront in project via SDK for PHP
Phase 1: Creation of a simple animal gallery website and an admin dashboard linked to a database.
        The pictures/videos of the animals are stored locally on the server (a public imaage directory) anytime the admine uploads them to the from the dashboard.

Phase 2: Use AWS SDK for PHP to automate storing of images in S3 bucket instead of local storage. 
        The S3 will have a Cloudfront infront of it to handle a secured and faster Content Delivery.