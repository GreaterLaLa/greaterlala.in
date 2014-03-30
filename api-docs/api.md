FORMAT: 1A
HOST: http://greaterlala.in/api

# GreaterLaLa.in API

# Authentication

No authentication. API endpoints are read-only.

# Group Suggestions

## Suggestions List [/suggestions]

+ Model

    + Headers

            Content-Type: application/json

    + Body

            [
                {
                    id: 1,
                    type: "text"
                    content: "lorem ipsum dolor",
                    created_at: "2007-04-05T12:30-04:00",
                    updated_at: "2007-04-05T12:30-04:00"
                },
                {
                    id: 2,
                    type: "text"
                    content: "et tu, Brutae?",
                    created_at: "2007-04-05T12:30-04:00",
                    updated_at: "2007-04-05T12:30-04:00"
                }
            ]

### Get Suggestions [GET]
Get a list of suggestions

+ Response 200

    [Suggestions List][]


## Suggestion [/subbestions/{id}]
A single suggestion

+ Parameters

    + id (required, integer, `1`) ... The note ID

+ Model

    + Headers

            Content-Type: application/json

    + Body

            {
                id: 1,
                type: "text"
                content: "lorem ipsum dolor",
                created_at: "2007-04-05T12:30-04:00",
                updated_at: "2007-04-05T12:30-04:00"
            }

### Get Suggestion [GET]
Get a single suggestion.

+ Response 200

    [Suggestion][]

+ Response 404

    + Body

            Not found