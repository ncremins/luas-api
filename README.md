Endpoint for getting Luas (Dublin light rail), times and geo-coded data.

Updated to use a more simpler way of grabbing data from Luas' endpoint.

This endpoint relies on http://www.luas.ie API endpoint and may break at any time, I will try my best to keep it updated.

A working example can be seen [here](http://www.neilcremins.com/luas/v2/index.php?action=stations) and [here](http://www.neilcremins.com/luas/v2/index.php?action=times&station=STS)

Example #1: Get times of next Luas in both directions.

index.php?action=**times**&station=**STS**

Result:
```javascript
{
    "message": "All services operating normally",
    "trams": [{
        "direction": "Inbound",
        "destination": "No trams forecast"
    }, {
        "direction": "Outbound",
        "dueMinutes": "3",
        "destination": "Brides Glen"
    }, {
        "direction": "Outbound",
        "dueMinutes": "15",
        "destination": "Brides Glen"
    }]
}
```


Example #2: Get the list of stations including GPS coordinates / Park & Ride / Cycle Racks information.

index.php?action=**stations**

```javascript
{
	"stations": [
		{
			"shortName": "STS",
			"displayName": "St. Stephen's Green",
			"displayIrishName": "Faiche Stiabhna",
			"line": "Green",
			"cycle": 0,
			"car": 0,
			"coordinates": {
				"latitude": 53.339072,
				"longitude": -6.261333
			}
		},
		{
			"shortName": "HAR",
			"displayName": "Harcourt Street",
			"displayIrishName": "Sráid Fhearchair",
			"line": "Green",
			"cycle": 1,
			"car": 0,
			"coordinates": {
				"latitude": 53.333358,
				"longitude": -6.262650
			}
		},
		{
			"shortName": "CHA",
			"displayName": "Charlemont",
			"displayIrishName": "Charlemont",
			"line": "Green",
			"cycle": 1,
			"car": 0,
			"coordinates": {
				"latitude": 53.330669,
				"longitude": -6.258683
			}
		},
		...
```


Example #3: Get dummy times for trams in both directions. This is useful for testing purposes, particularly when services have stopped for the night. This data is always the same and is as below.

index.php?action=**dummytimes**

```javascript
{
    "message": "All services operating normally",
    "trams": [
        {
            "destination": "Test Stop 1",
            "direction": "Inbound",
            "dueMinutes": "2"
        },
        {
            "destination": "Test Stop 1",
            "direction": "Inbound",
            "dueMinutes": "8"
        },
        {
            "destination": "Test Stop 1",
            "direction": "Inbound",
            "dueMinutes": "14"
        },
        {
            "destination": "Test Stop 2",
            "direction": "Outbound",
            "dueMinutes": "4"
        },
        {
            "destination": "Test Stop 2",
            "direction": "Outbound",
            "dueMinutes": "11"
        },
        {
            "destination": "Test Stop 2",
            "direction": "Outbound",
            "dueMinutes": "18"
        }
    ]
}
```
