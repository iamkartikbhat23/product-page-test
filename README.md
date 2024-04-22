##Task - Completed Both Front-end and Back-end

### Back-end - Laravel API

------------
- created `apiResource` route inside a `api.php` file , this creates following routes as api endpoints

| Method      | API | Purpose |
| --------- | -----| --------- :|
| GET  | ` /products ` | To list all the products |
| POST     |   `/products` | to create a new product |
| GET      |   ` /products/{productId}` | To fetch a specific product  |
| PUT      |    ` /products/{productId}` | To update a specific product |
| DELETE      |    `/products/{productId}` | To delete specific product |

- created `ProductController` to define structure of these endpoints. that contains `index()`, `store()`, `show()` , `update()` , `destroy()` methods for respective endpoints
- created `Product` , `ProductImage` ,  `ProductDiscount` Models the define database table architecture.

| Table Name     | Relationship |
| --------- |--------- :|
| products  |  - |
| product_images     |   **HasMay** with products |
| product_discounts      |   **HasOne** with products |

- created `StoreProductRequest` to validate input values received to insert or update the product.

- created `ProductResource` , `ProductImageResource`, `ProductDiscountResource` to normalize attributes set available for access.

- used sanctum package for the authentication of the api requests.

- created migration for the table structure of the Product, ProductImage, ProducDiscount 

- created Factories for the above table that generates appropriate fake rows for the tables

- mentioned classes of these factories inside a default Seeder file (`DatabaseSeeder.php`) with number of fake rows to be generated for each table.

###**NOTE** : As we need a Autherization token to access the api, it is required to create atleast 1 user entry inside a users table.

- after running `php artisan db:seed` command we can observe fake entries created for our all the databse tables.

- the follow these steps to generate authorization token 
	 	run ` php artisan tinker ` 
		then `User::first()->createToken('access') ` this will create a new entry/row for personnel access token table of the databse and displays a token below. then copy `plainTextToken` from it, this will be authorization token for the api calls. 
		eg.    5|nckv2EXk0JrMHDCkV1W4St1lIkTsxIzo7hvAbsfE 

### Now API are ready to use/test either from front-end app or using Postman Interface



#### NOTE : Please add authorization token created above to the line mentioned below from `app.js` file present under `/resources/js`

`'Authorization': 'Bearer <Authorization Token>'`

### Fron-end -Vue 3 + TailwindCSS
- used TailwindCSS (as a CDN) to style all the components of the Front-end app
- after running `127.0.0.1:800` it redirects to `127.0.0.1:800/#/products` usrl that shows all the products exists within products table by calling the `/products` api endpoint.
- each prodcut has a hyper link to view them on a seperate page, specific product details will be fetched using its slug value using` /products/{productId}` api endpoint.
- on a product detail page for a mobile version image slider used swpier js plugin.
- hit ''
- `127.0.0.1:800/#/listProducts` url to load all the product in tabluar form with a edit and delete options provided.
- to perfom edit and delete operations respective api endpoint were used.
- used **axios** package to call all the apis endpoints
- developed product detail page as per the design mentioned n the task.
