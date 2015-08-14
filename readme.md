# Newsletter API for Laravel

## Installing with composer
```
$ composer require wilsoncreative/newsletter
```

Then open your ```app/config/app.php``` and add the following into your providers array.
```
WilsonCreative\Newsletter\NewsletterServiceProvider::class
```

## Newsletter API Documentation

### API routes:
```
GET /list/
GET /list/find/{list_id}
DELETE /list/delete/{list_id}
```

```
GET /newsletter/
GET /newsletter/find/{newsletter_id}
DELETE /newsletter/delete/{newsletter_id}
```

```
POST /subscriber/add
GET /subscriber/{list_id}
GET /subscriber/{list_id}/find/{subscriber_email}
DELETE /subscriber/{list_id}/delete/{subscriber_email}
```

Subscribe POST-data example:
```
Array('list_id' => {list_id}, 'email' => {subscriber_email} )
```