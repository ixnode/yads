# madosa

A manager for storing and visualising documents, document relationships and making all entities available via an API.

## Run API

With the help of the API, document types and documents can be created. It is also used to create the document relationships.

## Upkeep

### Recreate db schema

```bash
$ bin/console doctrine:schema:drop --force && \
  bin/console doctrine:schema:create && \
  bin/console doctrine:fixtures:load -n
```

## Examples

### Create `DocumentType` entity

#### Create `DocumentType` data

```bash
❯ vi document.type.task.json
```

<details>
	<summary>Click to view content of `document.type.task.json`</summary>

```json
{
  "type": "task",
  "allowedAttributes": {
    "$id": "document.data.task.schema.json",
    "$schema": "https://json-schema.org/draft/2020-12/schema",
    "title": "Task document data",
    "description": "Data from document of type task",
    "type": "object",
    "additionalProperties": false,
    "properties": {
      "title": {
        "type": "string",
        "minLength": 2,
        "maxLength": 255,
        "description": "The title of the task."
      },
      "description": {
        "type": "string",
        "minLength": 10,
        "maxLength": 65535,
        "description": "The description of the task."
      },
      "has_date_of_completion": {
        "type": "boolean"
      },
      "date_of_completion": {
        "type": "string",
        "format": "date",
        "description": "The date on which this task must be completed."
      }
    },
    "required": [
      "title",
      "description",
      "has_date_of_completion"
    ]
  },
  "defaults": [
    "title"
  ]
}
```
</details>

#### Post new `DocumentType` entity

```bash
❯ curl -X 'POST' -s \
  'https://127.0.0.1:8004/api/v1/document_types' \
  -H 'accept: application/ld+json' \
  -H 'Content-Type: application/ld+json' \
  -d '@document.type.task.json' | jq .
```

<details>
	<summary>Click to view response of POST</summary>

```json
{
  "@context": "/api/v1/contexts/DocumentType",
  "@id": "/api/v1/document_types/1",
  "@type": "DocumentType",
  "id": 1,
  "type": "string",
  "allowedAttributes": {
    "$id": "document.data.task.schema.json",
    "$schema": "https://json-schema.org/draft/2020-12/schema",
    "title": "Task document data",
    "description": "Data from document of type task",
    "type": "object",
    "additionalProperties": false,
    "properties": {
      "title": {
        "type": "string",
        "minLength": 2,
        "maxLength": 255,
        "description": "The title of the task."
      },
      "description": {
        "type": "string",
        "minLength": 10,
        "maxLength": 65535,
        "description": "The description of the task."
      },
      "has_date_of_completion": {
        "type": "boolean"
      },
      "date_of_completion": {
        "type": "string",
        "format": "date",
        "description": "The date on which this task must be completed."
      }
    },
    "required": [
      "title",
      "description",
      "has_date_of_completion"
    ]
  },
  "defaults": [
    "title"
  ],
  "createdAt": "2021-08-04T21:03:54+00:00",
  "updatedAt": "2021-08-04T21:03:54+00:00"
}
```
</details>

### Create `Document` entity

#### Create `Document` data

```bash
❯ vi document.task.json
```

<details>
	<summary>Click to view content of `document.task.json`</summary>

```json
{
  "data": {
    "title": "Lohnsteuererklärung einrichen",
    "description": "Die Lohnsteuererklärung muss eingereicht werden.",
    "has_date_of_completion": false
  },
  "documentType": "/api/v1/document_types/1"
}
```
</details>

#### Post new `Document` entity

```bash
❯ curl -X 'POST' -s \
  'https://127.0.0.1:8004/api/v1/documents' \
  -H 'accept: application/ld+json' \
  -H 'Content-Type: application/ld+json' \
  -d '@document.task.json' | jq .
```

<details>
	<summary>Click to view response of POST</summary>

```json
{
  "@context": "/api/v1/contexts/Document",
  "@id": "/api/v1/documents/1",
  "@type": "Document",
  "data": {
    "title": "Lohnsteuererklärung einrichen",
    "description": "Die Lohnsteuererklärung muss eingereicht werden.",
    "has_date_of_completion": false
  },
  "documentType": "/api/v1/document_types/1",
  "id": 1,
  "createdAt": "2021-08-04T21:47:58+00:00",
  "updatedAt": "2021-08-04T21:47:58+00:00"
}
```
</details>
