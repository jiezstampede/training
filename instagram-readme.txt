#INSTAGRAM MODULE

requirement to get access token
*IG CREDENTIAL

steps on getting the access token.
1. login to instagram.com/developer using ig CREDENTIAL
2. click register your application
3. click register a new client then fill up ff:
-application name
-description
-website URL
-valid redirect
4. click manage then go to security
5. uncheck disable implicit OAuth then update client
6. go to https://www.instagram.com/oauth/authorize/?client_id=CLIENT_ID&redirect_uri=REDIRECT_URL&response_type=token&scope=public_content
7. get access token


requirements to use General getIGPost
1. access token
2. create general/site option with a slug of "instagram-feed-token" and "instagram-feed-size"

note: instagram-feed-size is optional but default value is 8..

to use General getIGPost function
for laravel frontend
* {{ General::getIGPosts() }} //returns array of arrays

for react
add "use Acme\Facades\General;" to namespace 
use General::getIGPosts() on controller with "use Acme\Facades\General;" //returns array of arrays;

sample data

{
    "data": [{
        "comments": {
            "count": 0
        },
        "caption": {
            "created_time": "1296710352",
            "text": "Inside le truc #foodtruck",
            "from": {
                "username": "kevin",
                "full_name": "Kevin Systrom",
                "type": "user",
                "id": "3"
            },
            "id": "26621408"
        },
        "likes": {
            "count": 15
        },
        "link": "http://instagr.am/p/BWrVZ/",
        "user": {
            "username": "kevin",
            "profile_picture": "http://distillery.s3.amazonaws.com/profiles/profile_3_75sq_1295574122.jpg",
            "id": "3"
        },
        "created_time": "1296710327",
        "images": {
            "low_resolution": {
                "url": "http://distillery.s3.amazonaws.com/media/2011/02/02/6ea7baea55774c5e81e7e3e1f6e791a7_6.jpg",
                "width": 306,
                "height": 306
            },
            "thumbnail": {
                "url": "http://distillery.s3.amazonaws.com/media/2011/02/02/6ea7baea55774c5e81e7e3e1f6e791a7_5.jpg",
                "width": 150,
                "height": 150
            },
            "standard_resolution": {
                "url": "http://distillery.s3.amazonaws.com/media/2011/02/02/6ea7baea55774c5e81e7e3e1f6e791a7_7.jpg",
                "width": 612,
                "height": 612
            }
        },
        "type": "image",
        "users_in_photo": [],
        "filter": "Earlybird",
        "tags": ["foodtruck"],
        "id": "22721881",
        "location": {
            "latitude": 37.778720183610183,
            "longitude": -122.3962783813477,
            "id": "520640",
            "street_address": "",
            "name": "Le Truc"
        }
    },
    {
        "videos": {
            "low_resolution": {
                "url": "http://distilleryvesper9-13.ak.instagram.com/090d06dad9cd11e2aa0912313817975d_102.mp4",
                "width": 480,
                "height": 480
            },
            "standard_resolution": {
                "url": "http://distilleryvesper9-13.ak.instagram.com/090d06dad9cd11e2aa0912313817975d_101.mp4",
                "width": 640,
                "height": 640
            },
        "comments": {
            "count": 2
        },
        "caption": null,
        "likes": {
            "count": 1
        },
        "link": "http://instagr.am/p/D/",
        "created_time": "1279340983",
        "images": {
            "low_resolution": {
                "url": "http://distilleryimage2.ak.instagram.com/11f75f1cd9cc11e2a0fd22000aa8039a_6.jpg",
                "width": 306,
                "height": 306
            },
            "thumbnail": {
                "url": "http://distilleryimage2.ak.instagram.com/11f75f1cd9cc11e2a0fd22000aa8039a_5.jpg",
                "width": 150,
                "height": 150
            },
            "standard_resolution": {
                "url": "http://distilleryimage2.ak.instagram.com/11f75f1cd9cc11e2a0fd22000aa8039a_7.jpg",
                "width": 612,
                "height": 612
            }
        },
        "type": "video",
        "users_in_photo": null,
        "filter": "Vesper",
        "tags": [],
        "id": "363839373298",
        "user": {
            "username": "kevin",
            "full_name": "Kevin S",
            "profile_picture": "http://distillery.s3.amazonaws.com/profiles/profile_3_75sq_1295574122.jpg",
            "id": "3"
        },
        "location": null
    },
   ]
}
