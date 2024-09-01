# Product Catalog

This project provides a RESTful API for managing a product catalog, built with PHP and MySQL using Symfony.

## Overview

The API allows you to perform CRUD (Create, Read, Update, Delete) operations on products in the catalog.

## API Usage

- **Base URL Prefix:** All endpoints are prefixed with `api`. For example, to access the products endpoint, use `api/products`.
- **Resource Identification:** To interact with a specific product (e.g., retrieve, update, or delete), append the product ID to the `products` endpoint. For example, to update or delete the product with ID 4, use `api/products/4`.
- **Request Formats:** The API accepts JSON payloads for the following HTTP methods:
  - **POST:** Create a new product.
  - **PUT/PATCH:** Update an existing product.
  - **DELETE:** Remove a product.
