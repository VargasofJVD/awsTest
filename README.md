# awsTest
    testing for how to integrate S3 and Cloudfront in project via SDK for PHP
    
    #Phase1: Creation of a simple animal gallery website and an admin dashboard linked to a database.
            The pictures/videos of the animals are stored locally on the server (a public imaage directory) anytime the admine uploads them to the from the dashboard.

    #Phase2: Use AWS SDK for PHP to automate storing of images in S3 bucket instead of the local storage on the server. 
            The S3 will have a Cloudfront infront of it to handle a secured and faster Content Delivery.
            *Secured S3 access: S3 will be set to private and allow access by Cloudfront only
            *Faster Content Deliver: Cloudfront caches content on edge locations upon first retrieval. Subsequent request/deliveries will be the already cached content at the edge location.