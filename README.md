# YADS

> *Yet another document store*

A manager for storing and visualising documents, document relationships and making all entities available via an API.

## 1. Run API

With the help of the API, document types and documents can be created. It is also used to create the document relationships.

### 1.1 Start local environment

```bash
❯ docker-compose up -d
```

<details>
	<summary>Click to view the output of docker-compose</summary>

```bash
Creating network "network-internal-org-getyads-www" with the default driver
Creating mariadb-10.6.3-org-getyads-www      ... done
Creating mariadb-10.6.3-org-getyads-www-test ... done
Creating php-8.0.9-cli-org.getyads.www       ... done
Creating php-8.0.9-apache-org.getyads.www    ... done
```
</details>

#### Command line

```bash
❯ docker-compose exec php php -v
PHP 8.0.9 (cli) (built: Jul 30 2021 00:29:20) ( NTS )
Copyright (c) The PHP Group
Zend Engine v4.0.9, Copyright (c) Zend Technologies
    with Zend OPcache v8.0.9, Copyright (c), by Zend Technologies
❯ docker-compose exec php bin/console -V
Symfony 5.3.6 (env: dev, debug: true)
❯ docker-compose exec php composer -V
Composer version 2.1.5 2021-07-23 10:35:47
```

#### URLs

* API Platform: http://localhost:8080/api/v1/docs.html
* DB port: `3333`
* Test DB port: `3334`

#### Choice / alternative

Alternatively, one can also start the Symfony server and only use the Docker database. This variant is more performant than the local Docker variant, especially on the Mac, but requires an installed Symfony client:

```bash
❯ symfony server:ca:install
❯ symfony server:start -d
```

<details>
	<summary>Click to view the output of `symfony server:start`</summary>

```bash

 [OK] Web server listening
      The Web server is using PHP FPM 8.0.9
      https://127.0.0.1:8004


Stream the logs via symfony server:log
```
</details>

#### Alternative URLs

* API Platform: https://localhost:8004/api/v1/docs.html
* DB port: `3333`
* Test DB port: `3334`


### 1.2 Upkeep

#### Reinitialize db

```bash
❯ composer reinitialize-db-prod
```

<details>
	<summary>Click to view the output of `composer reinitialize-db-prod`</summary>

```bash

 !
 ! [CAUTION] This operation should not be executed in a production environment!
 !

 Creating database schema...


 [OK] Database schema created successfully!


> bin/console doctrine:fixtures:load -n

   > purging database
   > loading App\DataFixtures\AppFixtures
```
</details>

## 2. Examples

### Create `DocumentType` entity

#### Create `DocumentType` data

```bash
❯ vi data/json/document.type.task.json
```

<details>
	<summary>Click to view content of `data/json/document.type.task.json`</summary>

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
  -d '@data/json/document.type.task.json' | jq .
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
❯ vi data/json/document.task.json
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
  -d '@data/json/document.task.json' | jq .
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

### Get `Document` entities

#### All entities

```bash
❯ curl -s \
  'https://127.0.0.1:8004/api/v1/documents' \
  -H 'Content-Type: application/ld+json' | jq .
```

<details>
	<summary>Click to view response of GET /api/v1/documents</summary>

```json
{
  "@context": "/api/v1/contexts/Document",
  "@id": "/api/v1/documents",
  "@type": "hydra:Collection",
  "hydra:member": [
    {
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
  ],
  "hydra:totalItems": 1
}
```
</details>


#### Single entity

```bash
❯ curl -s \
  'https://127.0.0.1:8004/api/v1/documents/1' \
  -H 'Content-Type: application/ld+json' | jq .
```

<details>
	<summary>Click to view response of GET /api/v1/documents</summary>

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
