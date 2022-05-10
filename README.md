## Instalacja

Po sklonowaniu repozytorium należy wykonać następujące kroki:

- Utworzyć plik ```.env``` i skopiować do niego zawartość pliku ```.env.example```
- W katalogu projektu wykonujemy polecenie ```composer install```
- Następnie ```./vendor/bin/sail up```

## Migracja i seedowanie

- Migracje wykonujemy poleceniem ```./vendor/bin/sail artisan migrate```
- Następnie seedujemy bazę danych ```./vendor/bin/sail artisan db:seed```

Teraz możemy wykonywać zapytania do API i uzyskać token uwierzytelniający.

## Testy

Testy uruchamiane są przy uruchomionym projekcie za pomocą polecenia ```./vendor/bin/sail artisan test```

## Opis API

W repozytorium załączony jest plik ```rekrutacyjny.postman_collection.json``` który można zaimportować do Postmana, jest
to gotowa kolekcja zapytań do api, dzięki Postmanowi można również wygenerować dokumentację.
Opiszę po krótce możliwe zapytania tutaj.

## Uzyskiwanie tokenu

Aby uzyskać token, wykonujemy zapytanie ```POST``` pod uri ```localhost/api/auth/login``` z następującym Body:

```
{
    "email": "user@user.com",
    "password": "password"
}
```

To dane do użytkownika, który został zaseedowany do bazy. W odpowiedzi otrzymamy token pozwalający na wykonywanie
operacji tworzenia/modyfikacji/usunięcia na produktach.

### Otrzymany token należy umieścić w zakładce Authorization, typ tokenu to Bearer

Możemy utworzyć własnego użytkownika wykonujemy zapytanie ```POST``` pod uri ```localhost/api/auth/signup``` z
następującym Body:

```
{
    "email": "user@email.com",
    "name": "User Name",
    "password": "password"
}
```

## Produkty

Zapytania dotyczące produktów wykonujemy pod uri ```localhost/api/product/```

### Tworzenie produktu

```POST``` z Body:

```
{
    "name": "Nazwa Produkty",
    "quantity": 100,
    "price": "99,99",
    "code": "A2EQW900"
}
```

### Modyfikacja produktu

```PUT``` pod  ```localhost/api/product/{id}``` z Body:

```
{
    "name": "Nazwa Produkty",
    "quantity": 100,
    "price": "99,99",
    "code": "A2EQW900"
}
```

### Lista produktów

```GET``` pod  ```localhost/api/product/```

Lista produktów może być filtrowana, dostępne filtry to:
```priceBelow```, ```priceAbove```, ```name```, ```quantityAbove```, ```quantityBelow```, ```code```
Przykład Body:

```
{
    "name": "niepełnanazwa",
    "quantityAbove": 10,
    "quantityBelow": 20,
    "priceAbove": 10,
    "priceBelow": 50,
    "code": "PEŁNYKOD"
}
```

### Produkt o konkretnym id

```GET``` pod  ```localhost/api/product/{id}```

### Usunięcie produktu

```DELETE``` pod  ```localhost/api/product/{id}```
