# Result & Error Handling
## First Layer: Database
- Table 'health-logger.wp_custommeta' doesn't exist.
- You have an error in your SQL syntax
- Table '%s' already exists
- Unknown table '%s'
- Column '%s' cannot be null
- Duplicate column name '%s'
- Key column '%s' doesn't exist in table
- Can't write; duplicate key in table '%s'
- ...

## Second Layer: Definition of API
- Success -> return `data`
- Failed -> return `error` (data is not defined in result) [HTTP-REST-API-Standard-Error?]

## Third Layer: Callback in Client
- Check request
- Check data -> return `data` or `error` based on success or data (custom or response error message)


## List of http status codes
- 200 -> success
- 201 -> created
- 400 -> 
- 404 -> 
- 500 -> 

https://stackoverflow.blog/2020/03/02/best-practices-for-rest-api-design/
400 Bad Request – This means that client-side input fails validation.
401 Unauthorized – This means the user isn’t not authorized to access a resource. It usually returns when the user isn’t authenticated.
403 Forbidden – This means the user is authenticated, but it’s not allowed to access a resource.
404 Not Found – This indicates that a resource is not found.
500 Internal server error – This is a generic server error. It probably shouldn’t be thrown explicitly.
502 Bad Gateway – This indicates an invalid response from an upstream server.
503 Service Unavailable – This indicates that something unexpected happened on server side (It can be anything like server overload, some parts of the system failed, etc.).

https://dev.to/khaosdoctor/the-complete-guide-to-status-codes-for-meaningful-rest-apis-1-5c5
100s: These are informational codes, just to acknowledge that the request has been received and it's being processed.
200s: Success codes, returned when everything has been processed or understood properly, generally, this means that the client does not need to perform any more actions
300s: Redirection codes, meaning that the client should request that resource somewhere else
400s: Client error codes, when the client messed things up
500s: Server error codes, when the server messed things up

If I don't know who is making the request, then it's 401 - Unauthorized
If I do know who's making the request, but the user doesn't have permissions to do so, then it's 403 - Forbidden

----------------------------------------------------------------------------------------------------------
# Introduction to the MySQL UNIQUE index
To enforce the uniqueness value of one or more columns, you often use the PRIMARY KEY constraint. However, each table can have only one primary key. Hence, if you want to have a more than one column or a set of columns with unique values, you cannot use the primary key constraint.

Luckily, MySQL provides another kind of index called UNIQUE index that allows you to enforce the uniqueness of values in one or more columns. Unlike the PRIMARY KEY index, you can have more than one UNIQUE index per table.

To create a UNIQUE index, you use the CREATE UNIQUE INDEX statement as follows:
```
CREATE UNIQUE INDEX index_name ON table_name(index_column_1,index_column_2,...);
```

Another way to enforce the uniqueness of value in one or more columns is to use the UNIQUE constraint.
When you create a UNIQUE constraint, MySQL creates a UNIQUE index behind the scenes.
The following statement illustrates how to create a unique constraint when you create a table.
```
CREATE TABLE table_name(
...
   UNIQUE KEY(index_column_,index_column_2,...) 
);
```

In this statement, you can also use the UNIQUE INDEX instead of the UNIQUE KEY because they are synonyms.

If you want to add a unique constraint to an existing table, you can use the ALTER TABLE statement as follows:
```
ALTER TABLE table_name
ADD CONSTRAINT constraint_name UNIQUE KEY(column_1,column_2,...);
```

----------------------------------------------------------------------------------------------------------
# To Do list
## List of DB tasks
1. Add api for update sensors values.
2. Learn $wpdb error handling.
3. Learn wordpress call function on post create (for insert sensors records).
4. Study REST API response format best practices.
5. Find 404 page template.
6. Learn boolean variable type in DB.
7. Authentication for private APIs.
8. How to show lat and long on map.

## First Version to Jalal
1. Create metadata automatically by create post (must be unique)
2. Read and update metadata APIs

----------------------------------------------------------------------------------------------------------
# Logs
## PHP Console Log
function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
debug_to_console($data->post_modified);

## PHP Error Log
error_log("Custom Error Log: test");

----------------------------------------------------------------------------------------------------------
# Goole Map Link Example
https://www.google.com/maps/place/35.6891975+51.3889736