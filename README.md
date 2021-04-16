# XFAPI-Usergroup-List

Adds an endpoint to the XenForo 2 API to grab a full list of staff members from the board.

## Group Endpoint

Endpoint can be accessed at /api/users/group with a valid XF-Api-Key + id parameter (http://dev.xenforo/api/users/group?id=4 for Administrator)

This will be default override the groups endpoint if set.

## Groups Endpoint

Endpoint can be accessed at /api/users/group with a valid XF-Api-Key + comma separated parameter called ids (http://dev.xenforo/api/users/group?ids=1,2,3)


## Also

Huge thanks to Sim on XenForo forums for his release of 'Find User by Criteria' for the XenForo API, which pointed me in the right direction with this. Recommend also installing his addon if you're starting to use the XenForo API: https://xenforo.com/community/resources/api-endpoint-find-a-user-by-criteria.7876/
