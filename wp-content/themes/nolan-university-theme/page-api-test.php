<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script>
const headers = {
    "Ocp-Apim-Subscription-Key": "df0e380d527f4fbbaeaaec6bc33919f5"
}

function get_data_from_url() {
    var search_params = new URLSearchParams(window.location.search);
    var user_age = search_params.get("age");
    var user_ID = search_params.get("ID");
    var user_country = search_params.get("country");
    var user_gender = search_params.get("gender");

    switch (user_gender) {
        case "male":
            user_gender = 0;
            break;
        case "female":
            user_gender = 1;
            break;
        default:
            user_gender = 2;
    }
    return {
        "age": user_age,
        "ID": user_ID,
        "country": user_country,
        "gender": user_gender
    };
}

function get_session_id() {
    var session_data = {
        "name": "Data Collection",
        "description": "Data Collection - CONAPT",
        "sessionGroupName": "DataCollection",
        "measureID": "ba97aa6c-ae02-496d-9786-d14d1470b54c",
        "retentionPolicy": {
            "type": "Default"
        },
        "host": {
            "computeProvider": {},
            "storageProvider": {},
            "invokeAsAsynchronous": false
        },
        "eventNotifications": {
            "sessionCreated": false,
            "sessionComplete": false,
            "sessionArchived": false,
            "dataGathererCreated": false,
            "dataGathererComplete": true,
            "dataGathereringResultsAvailable": false,
            "dataGathereringComplete": false,
            "dataGathereringArchived": false,
            "evaluatorInvoked": false,
            "evaluatorResultsAvailable": false,
            "evaluatorComplete": false,
            "evaluatorArchived": false,
            "enrichmentInvoked": false,
            "enrichmentResultsAvailable": false,
            "enrichmentComplete": false,
            "enrichmentArchived": false
        },
        "runAs": {
            "identifier": "identifier",
            "jobCode": "jobCode"
        }
    };
    
    $.ajax({
        url: "https://projectjanus.azure-api.net/JANUS/2022-10/sessions/",
        type: "GET",
        data: JSON.stringify(session_data),
        headers: headers,
        success: function(response) {
            // console.log(response);
            // console.log(response.sessionID);
            redirect_user_to_url(response.sessionID);
        },
        error: function(error) {
            console.log(error);
            window.location.href = "https://mhs.com/404-error";
        }
    });
}

function redirect_user_to_url(sessionID) {
    var user_object = get_data_from_url();

    var url_data = {
        "dataGatherings": [
            {
                "resourceType": "DataGathering",
                "dataGathererID": "9da51665-89ee-4eeb-ae81-8ca9b5171ff6",
                "measureID": "ba97aa6c-ae02-496d-9786-d14d1470b54c",
                "observationItemSets": [
                {
                    "sourceID": "b96fd1cd-00eb-4836-8a01-cad59cbfa8e3",
                    "interpretAs": "54aa9833-2920-4160-82f0-b4b32c729c89",
                    "observationValues": {
                    "encodingSchema": "Encoded",
                    "delimiter": "|",
                    "items": `${user_object.age}|||${user_object.ID}`
                    },
                    "thumbprint": "a26d51cbbe25f59c1930a7dcab8eb94d",
                    "isValid": true
                },
                {
                    "sourceID": "b96fd1cd-00eb-4836-8a01-cad59cbfa8e3",
                    "interpretAs": "296d0ea6-6495-41aa-8911-f77926c77c29",
                    "observationValues": {
                    "encodingSchema": "Encoded",
                    "delimiter": "|",
                    "items": `${user_object.gender}|||${user_object.country}|||||||||||`
                    },
                    "thumbprint": "a26d51cbbe25f59c1930a7dcab8eb94d",
                    "isValid": true
                }
                ],
                "directives": {
                    "keyValuePairsArray": [
                      {
                        "key": "Language",
                        "value": "en-US"
                      },
                      {
                        "key": "TestOrder",
                        "value": "Views|Concentration|Sequences|Hands"
                      }
                    ]
                  }
            }
        ],
        "retentionPolicy": {
            "type": "Default"
        },
        "host": {
            "computeProvider": {},
            "storageProvider": {},
            "invokeAsAsynchronous": true
        },
        "eventNotifications": {},
        "runAs": {
            "identifier": "",
            "jobCode": ""
        }
    }
    
    $.ajax({
        url: `https://projectjanus.azure-api.net/JANUS/2022-10/sessions/${sessionID}/dataGatherers`,
        type: "GET",
        data: JSON.stringify(url_data),
        headers: headers,
        success: function(url_response) {
            // console.log(url_response);
            // console.log(url_response.resources[0].links[1].href);
            // window.location.href = url_response.resources[0].links[1].href;
        },
        error: function(url_error) {
            console.log(error);
            window.location.href = "https://mhs.com/404-error";
        }
    });
} 

$(document).ready(function() {
    get_session_id();
})


</script>

<div class="h-100 d-flex">
  <div class="spinner-border mx-auto my-auto" role="status">
    <span class="sr-only">Loading...</span>
  </div>
</div>