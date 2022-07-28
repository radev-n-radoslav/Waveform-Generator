# Waveform generator task
This is a recruitment tast build with the laravel framework.
In order to setup the application the following must be done:

## Pull the repository and set it up
```
git clone https://github.com/radev-n-radoslav/Waveform-Generator.git
cd Waveform-Generator
composer install
cp .env.example .env
php artisan key:generate
```

## Running the application localy
While in the root directory of the application run the following command and check that nothing else is running on port 8000
```
php artisan serve
```

## Testing the application
The application can be tested automatically or manually
### Automatic test
While in the root directory of the project run the following command to start the Feature tests
```
php artisan test
```
### Manual test
For manual testing I would recommend using something like ``Postman``.

To test the application manually send a POST HTTP request to``localhost:8000/api/process-call-data`` if you are running the local server. In order for the API to work you need to have an ``Accept: application/json`` header to your request, the encoding should be form-data or  and the body must contain the following structure:
```
user_channel: txt file from the task example
customer_channel: txt file from the task example
```

Here is an example of the postman configuration I used:
![Screenshot 1](https://lh3.googleusercontent.com/JQRf_w__Jmh30KG36o_IlUg20zKYgA5NNk0vFAKxfHYHKAuS9eTR6Vk9LKlKxVYE6H705VwOxduL9zXYdLNhMKP8aRzE1hgV9d9XkBz311-BnZJZT5mwUVHTOkWJ_OfA1Q3h_3SlQA=w567-h360-no)
![Screenshot 2](https://lh3.googleusercontent.com/ebh9YhGYWyPNy8W1u9g3PiDS1Uv5hTTXAnRS3JFesag0qXLaITWV6KVFeO9gFdZ55rvmKRWc2BXGptMRe8eUOuPt1_5rAdN9dx5EAI_ThDdUy-i3Cy7K5i30DjjQSTeja5Tv45CYR0E0h3KDSm_9tltmORikwjSge0dCmQtKm97EOGyCuFxB21h9t1AM3vkyZgZ8t_75MvKovCC5iVTG3amuHbhBG3tMUdKuhLzU--xiqPZqkQzuao4mhrUC1AZ8ICdtoHPGHYXafepDnATkxS0TPU3I7C7kpmb53vNxhGJdZfl49bhWqqwj2AYC7JGPXog35e9HrMjMxzJvStviz7RwcoEXXaUYhuIjeb8o4EQoChfXD9gHtmY1vcK_lFOdHjSfIPjU8fNUaAIVRCP4497PGUF2q0uW3ng45p7qwG0HiLKJ-R3-b3LmdjZMMRKj2pAOLNnK6FOmI_E_jiUFqytx4gemE4KRFHQl0luTvW8_9EIpYaG-CNc4WIA4ssIvEJamv_k_SM7dLLPx74NkTjtw4zm7YFTD8Qi4hD1AnL3P8cf1jguN5IJXxGmtNqxnteEWH1WLOOE_LHMxuqOCUo4VTqIUQO2Gyy-eR3uWCHh9FSnG2-5QA2UC91Tz_XbkR5eW9YNv4YH7wOfVHNGRgIp61um1PWdfWTSQwfABDNxb0gl-1J2rKxo8N_JC7HHSBckVHj0qq-PzqUV4FoNbQSKvkq2ag54eT-cGwhg3NmSTsDcTLWbcQaeKj2F2-j2WYGc5lwlKbY00QfRE5qCy5V2sBhOwMqgDuWhhHLVmFe-qIgb0eR6ExsNpe4pC-sAk_2AxNmymfJwOXii80Z5tL68ck3I=w647-h561-no?authuser=0)