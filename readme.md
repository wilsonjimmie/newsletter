# Newsletter API connection

API:
Get all newsletters: /newsletter/
Find newsletter by ID: /newsletter/find/{id}
Delete newsletter with ID: /newsletter/delete/{id}

Get all mailinglists: /list/
Find mailinglist by ID: /list/find/{id}
Delete mailinglist by ID: /list/delete/{id}

Get all subscribers in list: /subscriber/{list_id}
Subscribe (POST-data): /subscriber/add
Get subscriber in list by email: /subscriber/{list_id}/find/{email}
Delete subscriber in list by email: /subscriber/{list_id}/delete/{email}