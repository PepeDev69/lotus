# SHOP ARCH

## `GET - Product|Service Endpoints`

```js

// GET ALL PRODUCTS FILTERED BY CATEGORY
GET /shop/products
		category?='cremas'
		lang='es'

// GET ONLY PRODUCT BY SLUG WITH META SEO
GET /shop/product
		slug='example'
		lang='es'
		seo?=true


// GET ALL SERVICES FILTERED BY CATEGORY
GET /shop/services
		category?='dermatologia'
		lang='es'

// GET ONLY SERVICE BY SLUG WITH META SEO
GET /shop/service
		slug='masaje'
		lang='es'
		seo?=true

```

## `POST - Product|Service Endpoints`

```js
// VERIFY IF THE PRODUCT IS AVAILABLE IN STOCK
POST /shop/verify-product
{
	"id": 334,
	"quantity": 5
}

// FULL VERIFICATION
POST /shop/order/verify
{
    products: [
        {
            "id":196,
            "quantity":4
        },
		{
			"id": 197,
            "quantity": 3
		}
    ],
	services: [
		{
			"id": 890,
			"quantity": 1,
			"doctor": 2,
			"from": "2022-04-07 10:00:00",
			"to": "2022-04-07 11:00:00"
		},
		{
			"id": 890,
			"quantity": 1,
			"doctor": 2,
			"from": "2022-04-07 10:00:00",
			"to": "2022-04-07 11:00:00"
		}
	]
}

// CREATE AN ORDER AFTER CHECKING IF IT IS STILL AVAILABLE IN STOCK
POST /shop/order/create
{
    user: {
        "name": "Alexito",
        "last_name": "Second",
        "company": "The company",
        "email": "asegund@gmail.com",
        "phone": "8954373378",
        "address_1": "Lima, Huacho 885",
        "address_2": "Calle las flores 2piso",
        "city": "Lima",
        "state": "Lima",
        "postcode": 857459,
        "country": ""
    },
    products: [
        {
            "id": 196,
            "quantity": 2
        },
        {
            "id": 197,
            "quantity": 3
        },
    ],
	services: [
		{
			"id": 890,
			"quantity": 1,
			"doctor": 2,
			"from": "2022-04-07 10:00:00",
			"to": "2022-04-07 11:00:00"
		},
		{
			"id": 850,
			"quantity": 1,
			"doctor": 3,
			"from": "2022-04-07 11:00:00",
			"to": "2022-04-07 12:00:00"
		},
	]
}

```

# APPOINTMENT ARCH

### `Models`

`sql`

```sql

--- APPOINTEMNT HORARY ZONE:

--- EMPLOYE TABLE
CREATE TABLE `mv_doctor` (
	`id` BIGINT(10) UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`first_name` VARCHAR(15) NOT NULL,
	`last_name` VARCHAR(18) NOT NULL,
	`gender` ENUM('Masculino', 'Femenino') NOT NULL,
	`email` VARCHAR(20) NOT NULL,
	`avatar` VARCHAR(50) NOT NULL,
	`position` VARCHAR(50) NOT NULL
);

--- CLIENT TABLE
CREATE TABLE `mv_customer` (
	`id` BIGINT(10) UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT PRIMARY KEY
	`name` VARCHAR(128) NOT NULL
	`phone` VARCHAR(128) NOT NULL
	`email` VARCHAR(135) NOT NULL
);

--- CREATE TABLE FOR SAVE SERVICE ID AND PRICE PAYED
CREATE TABLE `mv_service` {
	`id` INT(20) UNSIGNED UNIQUE NOT NULL AUTO_INCREMET PRIMARY KEY,
	`service_id`
}

--- SCHEDULE TABLE
CREATE TABLE `mv_schedule` (
	`id` BIGINT(20) UNIGNED UNIQUE NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`from` TIMESTAMP NOT NULL,
	`to` TIMESTAMP NOT NULL,
	`doctor` BIGINT(10) UNSIGNED,
	`customer` BIGINT(10) UNSIGNED,
	`service` INT(20) UNSIGNED,
	FOREIGN KEY (doctor) REFERENCES `mv_doctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (customer) REFERENCES `mv_customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);


```

`TypeScript`

```ts
enum EmployeGender {
	M = "Male",
	F = "Female",
}

// Employe Interface
interface Employe {
	id: number;
	firstName: string;
	lastName: string;
	gender: EmployeGender;
	email: string;
	avatar: string;
}
```

## `GET`

```ts
// GET ALL DATES BY TYPE. DEFAULT RETURN AVAILABLE DATES;
GET / bookly / find;
type = "available" | "busy";
```

## `POST`

```js
POST /bookly/create
{
	"date": "2022-04-07 22:00:52",

}

```

## `PUT`

```js

PUT /bookly/update?id=458
{

}

```

## `DELETE`

```js
// DELETE ONE DATE OF APPOINTMENT
DELETE /bookly/delete?id=567

```

```php
DB::selectOne(
	"SELECT COUNT(*) as total FROM $table->posts WHERE ID IN (
		SELECT object_id FROM $table->term_relations WHERE term_taxonomy_id = (
			SELECT tr.term_id FROM $table->terms tr
				INNER JOIN $table->term_taxonomy tx ON tx.term_id = tr.term_id AND tx.taxonomy = 'product_cat' AND tx.count > 0 AND tx.parent != 0
				LEFT JOIN $table->terms trs ON trs.term_id = tx.parent
				LEFT JOIN $table->termmeta tm ON tm.term_id = tr.term_id AND tm.meta_key = '__term_lang'
			WHERE trs.slug = :parent AND tr.slug = :category AND tm.meta_value = :lang
		)
	)",
	[":parent" => $type, ":category" => $category, ":lang" => $lang]
)->total;

```

```json
[
	{
		"guid": "http://localhost/lotus/backend/wp-content/uploads/2022/04/product.jpg"
	},
	{
		"guid": "http://localhost/lotus/backend/wp-content/uploads/2022/04/product-gallery.jpg"
	},
	{
		"guid": "http://localhost/lotus/admin/wp-content/uploads/2022/04/bienestar-1.jpg"
	},
	{
		"guid": "http://localhost/lotus/admin/wp-content/uploads/2022/04/bienestar-2.jpg"
	}
]
```
