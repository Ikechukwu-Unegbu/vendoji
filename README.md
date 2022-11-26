## API DOCUMENTATION

## User Registration
    URL
    POST /api/register
    Headers: 'Accept: application/json',
    Body: 
        {
            "name": " ",
            "email": " ",
            "password": " ",
            "password_confirmation": " "
        }
    Example Validation Response JSON
    {
        "status": false,
        "message": "validation error",
        "errors": {
            "name": [
                "The name field is required."
            ],
            "email": [
                "The email field is required."
            ],
            "password": [
                "The password field is required."
            ],
            "password": [
                "The password must be at least 8 characters."
            ],
            "password_confirmation": [
                "The password confirmation field is required."
            ],
            "password_confirmation": [
                "The password confirmation and password must match."
            ]
        }
    }
    Example Success Response JSON
    {
        "status": "true",
        "message": "Account Created Successfully",
        "token": "2|mSmPSMn5UZjQFDJYamtRWBpVHREi82RVYVRpyJET"
        "data": {
            "name": "User",
            "email": "user@user.com",
            "access": "user",
            "updated_at": "2022-10-27T09:15:24.000000Z",
            "created_at": "2022-10-27T09:15:24.000000Z",
            "id": 1
        },
        "wallet": {
            "user_id": 1,
            "password": "$2y$10$WsnQl1a515RM96napfjT4ekHt6fK3DlJPim039HCHX08xdHD/1puC",
            "pass_phrase": "2N8oRg6wJpVw4iDdYpiDELXJGSU5ry7PLxP",
            "balance": "0.00000000",
            "coin_type": "btc",
            "updated_at": "2022-10-27T09:15:24.000000Z",
            "created_at": "2022-10-27T09:15:24.000000Z",
            "id": 1
        }
    }


## User Authentication
    URL
    POST /api/login
    Headers: 'Accept: application/json',
            
    Body: 
        {
            "email": " ",
            "password": " "
        }
    Example Validation Response JSON
        {
            "status": false,
            "message": "validation error",
            "errors": {
                "email": [
                    "The email field is required."
                ],
                "password": [
                    "The password field is required."
                ]
            }
        }
    Example Success Response JSON
        {
            "status": true,
            "message": "Logged In Successfully",
            "data": {
                "id": 1,
                "name": "Jane Doe",
                "email": "jane@ade.com",
                "email_verified_at": null,
                "phone": null,
                "image": null,
                "gender": null,
                "state": null,
                "town": null,
                "access": "user",
                "mycode": null,
                "myref": null,
                "block": null,
                "created_at": "2022-10-02T12:05:52.000000Z",
                "updated_at": "2022-10-02T12:05:52.000000Z"
            },
            "token": "2|VjAwae2LKmS4c2VtFwaFnrmYf9D6Y5dBTyqzfgQf"
        }


## Admin Registration
    URL
    POST /api/admin/register
    Headers: 'Accept: application/json',
    Body: 
        {
            "name": " ",
            "email": " ",
            "password": " ",
            "password_confirmation": " "
        }
    Example Validation Response JSON
    {
        "status": false,
        "message": "validation error",
        "errors": {
            "name": [
                "The name field is required."
            ],
            "email": [
                "The email field is required."
            ],
            "password": [
                "The password field is required."
            ],
            "password": [
                "The password must be at least 8 characters."
            ],
            "password_confirmation": [
                "The password confirmation field is required."
            ],
            "password_confirmation": [
                "The password confirmation and password must match."
            ]
        }
    }
    Example Success Response JSON
    {
        "status": "true",
        "message": "Account Created Successfully",
        "data": {
            "name": "User",
            "email": "user@user.com",
            "access": "user",
            "updated_at": "2022-10-01T15:08:33.000000Z",
            "created_at": "2022-10-01T15:08:33.000000Z",
            "id": 1
        },
        "token": "2|mSmPSMn5UZjQFDJYamtRWBpVHREi82RVYVRpyJET"
    }


## Admin Authentication
    URL
    POST /api/admin/login
    Headers: 'Accept: application/json',
            
    Body: 
        {
            "email": " ",
            "password": " "
        }
    Example Validation Response JSON
        {
            "status": false,
            "message": "validation error",
            "errors": {
                "email": [
                    "The email field is required."
                ],
                "password": [
                    "The password field is required."
                ]
            }
        }
    Example Success Response JSON
        {
            "status": true,
            "message": "Logged In Successfully",
            "data": {
                "id": 1,
                "name": "Jane Doe",
                "email": "jane@ade.com",
                "email_verified_at": null,
                "phone": null,
                "image": null,
                "gender": null,
                "state": null,
                "town": null,
                "access": "admin",
                "mycode": null,
                "myref": null,
                "block": null,
                "created_at": "2022-10-02T12:05:52.000000Z",
                "updated_at": "2022-10-02T12:05:52.000000Z"
            },
            "token": "2|VjAwae2LKmS4c2VtFwaFnrmYf9D6Y5dBTyqzfgQf"
        }


## User Profile
    URL
    GET /api/user/profile
    Headers: {
            'Accept: application/json',
            'Authorization: Bearer 2|VjAwae2LKmS4c2VtFwaFnrmYf9D6Y5dBTyqzfgQf'
        }
    Example Response JSON
        {
            "status": true,
            "message": "User Profile",
            "data": {
                "id": 1,
                "name": "Jane Doe",
                "email": "doe@gmail.com",
                "email_verified_at": null,
                "phone": null,
                "image": null,
                "gender": null,
                "state": null,
                "town": null,
                "access": "user",
                "mycode": null,
                "myref": null,
                "block": null,
                "created_at": "2022-10-02T12:05:52.000000Z",
                "updated_at": "2022-10-02T12:05:52.000000Z",
                "kin": null
            }
        }


## Edit Profile
    URL
    POST /api/user/profile/edit
    Headers: 
        {
            'Accept: application/json',
            'Authorization: Bearer 2|VjAwae2LKmS4c2VtFwaFnrmYf9D6Y5dBTyqzfgQf'
        }
    Body: 
        {
            "name": "",  
            "email":    "", 
            "phone":    "", 
            "gender":   "",    
            "state":    "", 
            "town": "",  
            'profile_image': "" 
        }
    Example Validation Response JSON
        "status": false,
        "message": "validation error",
        "errors": {
            "name": [
                "The name field is required."
            ],
            "email": [
                "The email field is required."
            ],
            "profile_image": [
                "The profile image must be an image.",
                "The profile image must not be greater than 2048 kilobytes."
            ]
        }
        
    Example Response JSON
        "status": "true",
        "message": "Profile Upadate Successfully",
        "data": {
            "id": 1,
            "name": "Jane Doe",
            "email": "doe@gmail.com",
            "email_verified_at": null,
            "phone": "09088990099",
            "image": "profile/1664719841.png",
            "gender": "Female",
            "state": "State",
            "town": "Town",
            "access": "user",
            "mycode": null,
            "myref": null,
            "block": null,
            "created_at": "2022-10-02T12:05:52.000000Z",
            "updated_at": "2022-10-02T14:10:41.000000Z"
        }
        
## User Wallet

    URL
    GET /api/user/wallets
    Headers: 
        {
            'Accept: application/json',
            'Authorization: Bearer 2|VjAwae2LKmS4c2VtFwaFnrmYf9D6Y5dBTyqzfgQf'
        }
    Response 
        {
            "data": [
                {
                    "id": 5,
                    "user_id": 9,
                    "password": "$2y$10$WsnQl1a515RM96napfjT4ekHt6fK3DlJPim039HCHX08xdHD/1puC",
                    "pass_phrase": "2N8oRg6wJpVw4iDdYpiDELXJGSU5ry7PLxP",
                    "coin_type": "btc",
                    "balance": "0.00",
                    "created_at": "2022-10-27T09:15:24.000000Z",
                    "updated_at": "2022-10-27T09:15:24.000000Z"
                },
                {
                    "id": 6,
                    "user_id": 9,
                    "password": "$2y$10$MTymSPBGAJ87FkdR8r.e1.nWn7mrdi/BJ2qMdKGr4Bta6S.0zWJEW",
                    "pass_phrase": "QgpaPMLp5hMVE3Zzh8KhBFN81TTVdrsbWc",
                    "coin_type": "lite",
                    "balance": "0.00",
                    "created_at": "2022-10-27T09:29:59.000000Z",
                    "updated_at": "2022-10-27T09:29:59.000000Z"
                },
                {
                    "id": 7,
                    "user_id": 9,
                    "password": "$2y$10$.qK34dCL.lXNZVuu/U2wWeG40YtjGKb9zdEKz3zNulbvmFEKaLidS",
                    "pass_phrase": "2NG5zeM175iMBXqN85S13nxuzFhVroWkUA6",
                    "coin_type": "doge",
                    "balance": "0.00",
                    "created_at": "2022-10-27T09:33:37.000000Z",
                    "updated_at": "2022-10-27T09:33:37.000000Z"
                }
            ]
        }

## Create New Wallet

    Create New Wallet
    BITCOIN, DOGECOIN & LITECOIN API are provided in creating new wallet
    Use btc for BITCOIN, doge for DOGECOIN & lite for LITECOIN while creating new wallet

    URL
    POST /api/user/wallet/create
    Headers: 
        {
            'Accept: application/json',
            'Authorization: Bearer 2|VjAwae2LKmS4c2VtFwaFnrmYf9D6Y5dBTyqzfgQf'
        }
    Body: 
        {
            "coin_type": "btc or doge or lite",
            "password": ""
        }
    Example Validation Response JSON
        {
            "status": false,
            "message": "validation error",
            "errors": {
                "coin_type": [
                    "The coin type field is required."
                ],
                "password": [
                    "The password field is required.",
                    "The password must be at least 4 characters."

                ]
            }
        }
    Response if wallet already exist
        {
            "status": false,
            "message": "Wallet doge already exists!",
            "data": []
        }
    Response
        {
            "status": true,
            "message": "Wallet Created Successfully",
            "data": {
                "user_id": 9,
                "password": "$2y$10$.qK34dCL.lXNZVuu/U2wWeG40YtjGKb9zdEKz3zNulbvmFEKaLidS",
                "pass_phrase": "2NG5zeM175iMBXqN85S13nxuzFhVroWkUA6",
                "balance": "0.00000000",
                "coin_type": "doge",
                "updated_at": "2022-10-27T09:33:37.000000Z",
                "created_at": "2022-10-27T09:33:37.000000Z",
                "id": 7
            }
        }


## Logout
    URL
    POST /api/logout
    Headers: {
            'Accept: application/json',
            'Authorization: Bearer 2|VjAwae2LKmS4c2VtFwaFnrmYf9D6Y5dBTyqzfgQf'
        }
    Response
        {
            "status": true,
            "message": "User Logged out Successfully"
        }
