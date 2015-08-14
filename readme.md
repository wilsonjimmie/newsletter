# Newsletter API Documentation

API routes:
```
Get all mailinglists: /list/
Find mailinglist by ID: /list/find/{id}
Delete mailinglist by ID: /list/delete/{id}
```

```
Get all newsletters: /newsletter/
Find newsletter by ID: /newsletter/find/{id}
Delete newsletter with ID: /newsletter/delete/{id}
```

POST-data example:
Array(
    'list_id' => {list_id},
    'email' => {email}
)
```
Subscribe (POST-data): /subscriber/add
Get all subscribers in list: /subscriber/{list_id}
Get subscriber in list by email: /subscriber/{list_id}/find/{email}
Delete subscriber in list by email: /subscriber/{list_id}/delete/{email}
```