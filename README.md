## PHP Developer Test Assignment

1. Implement simple REST API server as defined in the API documentation (OpenAPI)
2. Data generation / seeders
   - Implement a data generator and seeders for the initial filling of the database with data (50 users).
   - The data should be as close as possible similar to the data which a real user would fill.
3. POST request handling requirements:
   - The image needs to be cropped (center/center) and saved as jpg/jpeg image, with resolution at least 70x70px and size must not exceed 5MB.
   - The image should be optimized using the tinypng.com API.
   - An authorization token is needed only to demonstrate the ability to generate and use it.
   - The token is valid for 40 minutes and can be used for only one request. For the next registration, you will need to get a new one.
4. Implement frontend part, just to demonstrate how your server works. Without beautiful design and formatting, you can use any ready-made UI components that you feel comfortable working with. We will only be paying attention to the output of the data and verifying if form works.
   - Display a list of users with pagination buttons, output 6 users per page.
   - Create an add new user form. No validation is needed on the front-end part, all validations should be done only on the server side.

## Implementation

### Frontend part
<img src="https://i.postimg.cc/Z5yxcXGq/api1.jpg" alt="">
<img src="https://i.postimg.cc/PxNxbn73/api2.jpg" alt="">

### API documentation

Documentation is presented in two extensions - .json and .yaml, and available at internal addresses:
- http://api-test/docs/api-specification-json
- http://api-test/docs/api-specification-yaml

<img src="https://i.postimg.cc/0r1yqMyF/api3.jpg" alt="">

### Tests in Postman

All the queries was tested in Postman
