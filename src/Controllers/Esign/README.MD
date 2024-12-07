# Esign API

## API Documentation

This API provides the following services:

-   [Register]({{baseUrl}}/api/user/register) `POST` `{{baseUrl}}/api/user/register`
-   [Get Status by NIK]({{baseUrl}}/api/user/check/status) `POST` `{{baseUrl}}/api/user/check/status`
-   [Get Certificate Chain by NIK]({{baseUrl}}/api/user/certificate/chain/:id) `GET` `{{baseUrl}}/api/user/certificate/chain/:id`
-   [Request OTP by NIK]({{baseUrl}}/api/sign/get/totp) `POST` `{{baseUrl}}/api/sign/get/totp`
-   [Sign PDF by NIK & OTP]({{baseUrl}}/api/sign/pdf) `POST` `{{baseUrl}}/api/sign/pdf`
-   [Sign PDF by NIK & Passphrase]({{baseUrl}}/api/sign/pdfpassphrase) `POST` `{{baseUrl}}/api/sign/pdfpassphrase`
-   [Verify PDF]({{baseUrl}}/api/verify/pdf) `POST` `{{baseUrl}}/api/verify/pdf`

Below is a guide on how to use the available endpoints

### 1. Register
#### Details
#### - Method = `POST`
#### - Endpoint = `{{baseUrl}}/api/user/register`
#### - Path Parameters: `-`
#### - Request Header Parameters: `-`
#### - Request Body Parameters : 

| Parameter                | Type   | Description              | Required | Example Value       |
| :----------------------- | :----- | :----------------------- | :------- | :------------------ |
| `nama`                   | string | full name                | Yes      | `testing`           |
| `email`                  | string | email                    | Yes      | `testing@gmail.com` |
| `oid_instansi`           | string | oid instansi             | No       | ` null `               |
| `suratRekomendasiBase64` | string | surat rekomendasi base64 | No       | `{base64}`          |

#### Usage Example
`Endpoint` = `{{baseUrl}}/api/user/register`
#### - Request Header: `-`
#### - Request Body: 
```
{
    "nama": "testing",
    "email": "testing@gmail.com",
    "oid_instansi": "",
    "suratRekomendasiBase64": "NULL"
}
```
#### - Response Body :
```
{
    "error": "Email tidak valid",
    "status_code": 4015
}
```

### 2. Get Status by NIK
#### Details
#### - Method = `POST`
#### - Endpoint = `{{baseUrl}}/api/user/check/status`
#### - Path Parameters: `-`
#### - Request Header Parameters: `-`
#### - Request Body Parameters : 

| Parameter      | Type   | Description          | Required | Example Value      |
| :------------- | :----- | :------------------- | :------- | :----------------- |
| `nik`          | string | nik                  | Yes      | `3209145563023366` |

#### Usage Example
`Endpoint` = `{{baseUrl}}/api/user/check/status`
#### - Request Header: `-`
#### - Request Body: 
```
{
    "nik":"3209145804020011"
}
```
#### - Response Body :
```
{
    "status_code": "1111",
    "message": "Status Sertifikat Anda ISSUE",
    "status": "ISSUE"
}
```

### 3. Get Certificate Chain by NIK
#### Details
#### - Method = `GET`
#### - Endpoint = `{{baseUrl}}/api/user/certificate/chain/:id`
#### - Path Parameters: 

| Parameter | Type   | Description           | Required | Example Value      |
| :-------- | :----- | :-------------------- | :------- | :----------------- |
| `id`      | string | nik                   | Yes      | `1234567890123456` |

#### - Request Header Parameters: `-`
#### - Request Body Parameters : `-`
#### Usage Example
`Endpoint` = `{{baseUrl}}/api/user/certificate/chain/1234567890123456`
#### - Request Header: `-`
#### - Request Body: `-`
#### - Response Body :
```
{
    "success": true,
    "message": null,
    "data": [
        "-----BEGIN CERTIFICATE-----\nMIIEuTCCA6GgAwIBAgIUCbiHyeMlhrrlZXR/ERVd6qDUF/YwDQYJKoZIhvcNAQELBQAwRzERMA8G\r\nA1UEAwwIT1NEIERFTU8xJTAjBgNVBAoMHEJhZGFuIFNpYmVyIGRhbiBTYW5kaSBOZWdhcmExCzAJ\r\nBgNVBAYTAklEMB4XDTI0MTAwNzA3MjExN1oXDTI1MDQwNTA3MjExNlowbjEuMCwGA1UEDQwlNTEw\r\nMTcxTkVHVURYTVBKTF9UYW5kYSBUYW5nYW4gRGlnaXRhbDEZMBcGA1UEAwwQVXNlciBEZXZlbG9w\r\nbWVudDEUMBIGA1UECgwLS1BQTiBCZWthc2kxCzAJBgNVBAYTAklEMIIBIjANBgkqhkiG9w0BAQEF\r\nAAOCAQ8AMIIBCgKCAQEArgYNGXKOLub4dZoXoGWI7qZ1g43JOPl7T+HLy6rAKTHjB+37oL13Y74q\r\nue0uTB62DKcmNL706vRTKbFme/uB840gsNoH28njn0L9zrMQiAY64i08UpJI8oJQbYWGt3qpfrgZ\r\niMGH0z+nbKJGmjwJ0ouASq27Ix0UGZVzTDZ3GS3DyhQ+OW/JDU+HbDppZx8AS5f0IPAZRcxauQi8\r\nguALFLllQPwVd9yk/SsJreX1sL+DHCC8SljS0qY57E9PfcAQtRLcuAp+O/neTPifhgb7jV4t70g9\r\noOTN0LG8oC2z7qagj3F4mOq2J3XhIDxP4/QSy+NKVzqCwSG8GiAqRT7ROwIDAQABo4IBdDCCAXAw\r\nDAYDVR0TAQH/BAIwADAfBgNVHSMEGDAWgBRrzdI2mGlzKrEwN/lXTHwBhjv1rjByBggrBgEFBQcB\r\nAQRmMGQwMgYIKwYBBQUHMAKGJmh0dHA6Ly9jdnMtYnNyZS5ic3NuLmdvLmlkL29zZGRlbW8uY3J0\r\nMC4GCCsGAQUFBzABhiJodHRwOi8vY3ZzLWJzcmUuYnNzbi5nby5pZC9vY3NwZGV2MEoGA1UdIARD\r\nMEEwPwYIYIJoAQIBAgIwMzAxBggrBgEFBQcCARYlaHR0cHM6Ly9ic3JlLmJzc24uZ28uaWQvcHVi\r\nbGljL3BvbGljeTAXBgNVHSUBAf8EDTALBgkqhkiG9y8BAQUwNwYDVR0fBDAwLjAsoCqgKIYmaHR0\r\ncDovL2N2cy1ic3JlLmJzc24uZ28uaWQvb3NkZGVtby5jcmwwHQYDVR0OBBYEFNldhtlDWTEvtNZ7\r\nDYAv1RypY2jeMA4GA1UdDwEB/wQEAwIGwDANBgkqhkiG9w0BAQsFAAOCAQEAfLfbcsYW2IZxzZKN\r\nUiICkJFkgHzuI6D3/8CqjxujdeTgES2nY8G43DZf9OSxu3FX4rIbdNOmPd0o9M4+jd2sEV7XEAE4\r\n1F5HDpxLaxgC+ahMIXo6pHYUia2fo+vsIgVRWYBY8zhuFcU9Z8J02p26mLERepLwFLbYY2bVT7Ej\r\nGLXBgWyWcb19ujbk5aep2QV8Jbq2ZVJmb92qXvXnyRfqjD03fZgPTNq5OVmbxLVj4Vp7J2Mic1Bq\r\nng3tprXACXqsdeNY4uCmMZ6YNY5IPws+nrDNG2A3Mfhgtgal5ZaUc9P8Rse7jP4u5k456a9ndqVv\r\nxyAuSWsxDM6YqFJlHcffZw==\r\n-----END CERTIFICATE-----",
        "-----BEGIN CERTIFICATE-----\nMIIDczCCAlugAwIBAgIIDvNg9Ui+mjMwDQYJKoZIhvcNAQELBQAwRzERMA8GA1UE\nAwwIT1NEIERFTU8xJTAjBgNVBAoMHEJhZGFuIFNpYmVyIGRhbiBTYW5kaSBOZWdh\ncmExCzAJBgNVBAYTAklEMB4XDTE4MDQwODE3MjMyOFoXDTI4MDQwNzE3MjMyOFow\nRzERMA8GA1UEAwwIT1NEIERFTU8xJTAjBgNVBAoMHEJhZGFuIFNpYmVyIGRhbiBT\nYW5kaSBOZWdhcmExCzAJBgNVBAYTAklEMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8A\nMIIBCgKCAQEAjr2ArgvqTftVmrqjsr5O4bFqZzgeoSkfiL+GJ4eBKWmi5yE1BDwy\nTPcex41PjbFKUQ75a8ZSYhJUk5rzdbb8PHXyPieHMuz/YqMTFMw5xaO9nwDo43IR\nTumoSD0p4NY4apVJccvc8hjScpEqXJ9q9PPGUSH8/zUWaJJIR7F3P2rAEUEJZwSz\njFLVB2g/PaAq1YPAh1ODIbsn2wML6TPkpuH5EPtEFLGYUCMeF7F2nrMZoMKiTUmj\n+91ZMiGv7AqG+032nUp3ZsjdLY7vdy+hPP/V6EQ0aNOJssgv6cnKa4tRHQsDgi7W\ngdEhQpPrTvT14Hzd7DsyKntTJSv0XqpZawIDAQABo2MwYTAdBgNVHQ4EFgQUa83S\nNphpcyqxMDf5V0x8AYY79a4wDwYDVR0TAQH/BAUwAwEB/zAfBgNVHSMEGDAWgBRr\nzdI2mGlzKrEwN/lXTHwBhjv1rjAOBgNVHQ8BAf8EBAMCAYYwDQYJKoZIhvcNAQEL\nBQADggEBABgQXI/4/+tuJlPPTTJhW+RkKcoTvmt6y7Qc2nKAntTQB6k5XGCTT3f8\n82JBfyNhmqNMCAihsCuHlvcquh1vqy4NXZvqvhlTPr/hDGaJ6Yj+9QsVRJx7KoVr\nlW3M+s+lsS+tgQqSoeAu3z5rljFeWt2CB9xmnd2A9c4//Vy9oZOQlhs5Oo0DHGm4\nj3Muco88lREAPLXXyisNjA1i1L2gV05MUp0gPgoGjWguthxY+7kc/WGLitE9Mlz7\ntnhcBONxBjGkHPgbhSTcmegCT3XpwDllk3soeKqQEtxRTdPBa9QIlu2LR4wTMnwT\nZbilHFMSqr3CKaHQeKxUPMT5v094ktw=\n-----END CERTIFICATE-----"
    ]
}
```

### 4. Request OTP by NIK
#### Details
#### - Method = `POST`
#### - Endpoint = `{{baseUrl}}/api/sign/get/totp`
#### - Path Parameters: `-`
#### - Request Header Parameters: `-`
#### - Request Body Parameters : 

| Parameter | Type    | Description | Required | Example Value      |
| :-------- | :------ | :---------- | :------- | :----------------- |
| `nik`     | string  | nik         | Yes      | `1234567890123456` |
| `data`    | integer | data        | Yes      | `1`                |

#### Usage Example
`Endpoint` = `{{baseUrl}}/api/sign/get/totp`
#### - Request Header: `-`
#### - Request Body: 
```
{
    "nik": "1234567890123456",
    "data": 1
}
```
#### - Response Body :
```
{
    "success": true,
    "message": "TOTP berhasil dikirim, mohon cek email anda (388702 hantek.bsre@bssn.go.id)",
    "data": null
}
```

### 5. Sign PDF by NIK & OTP
#### Details
#### - Method = `POST`
#### - Endpoint = `{{baseUrl}}/api/sign/pdf`
#### - Path Parameters: `-`
#### - Request Header Parameters: `-`
#### - Request Body Parameters : 

| Parameter             | Type         | Description          | Required | Example Value      |
| :-------------------- | :----------- | :------------------- | :------- | :----------------- |
| `nik`                 | string       | nik                  | Yes      | `1234567890123456` |
| `totp`                | string       | otp                  | Yes      | `1234`             |
| `file`                | string       | base64 format        | Yes      | `{base64}`         |
| `signatureProperties` | array object | signature properties | Yes      | see below          |

#### Item Object Properties (for `signatureProperties`)

| Parameter     | Type    | Description       | Required | Example Value |
| :------------ | :------ | :---------------- | :------- | :------------ |
| `imageBase64` | string  | base64 format     | Yes      | `{base64}`    |
| `tampilan`    | string  | visible/invisible | Yes      | `VISIBLE`     |
| `page`        | integer | page number       | Yes      | `1`           |
| `originX`     | float   | coordinate X      | Yes      | `52.6`        |
| `originY`     | float   | coordinate Y      | Yes      | `0.0`         |
| `width`       | float   | width             | Yes      | `10.0`        |
| `height`      | float   | height            | Yes      | `20.5`        |
| `location`    | string  | location          | No       | `null`        |
| `reason`      | string  | reason            | No       | `null`       |
| `contactInfo` | string  | contact info      | No       | `null`        |

#### Usage Example
`Endpoint` = `{{baseUrl}}/api/sign/pdf`
#### - Request Header: `-`
#### - Request Body: 
```
{
    "nik": "{{nik}}",
    "totp": "000000",
    "signatureProperties": [
        {
            "imageBase64": "{{image_ttd_base64}}",
            "tampilan": "VISIBLE",
            "page": 1,
            "originX": 512.0,
            "originY": 0.0,
            "width": 100.0,
            "height": 75.0,
            "location": "null",
            "reason": "null",
            "contactInfo": "null"
        }
    ],
    "file": [
        "{{pdf_2_kb}}"
    ]
}
```
#### - Response Body :
```
{
    "time": 1407,
    "file": [
        "{{base64}}"
    ]
}
```

#### 6. Sign PDF by NIK & pdfpassphrase
#### Details
#### - Method = `POST`
#### - Endpoint = `{{baseUrl}}/api/sign/pdfpassphrase`
#### - Path Parameters:
#### - Request Header Parameters:
#### - Request Body Parameters : 

| Parameter             | Type         | Description          | Required | Example Value      |
| :-------------------- | :----------- | :------------------- | :------- | :----------------- |
| `nik`                 | string       | nik                  | Yes      | `1234567890123456` |
| `passphrase`          | string       | passphrase           | Yes      | `1234`             |
| `file`                | string       | base64 format        | Yes      | `{base64}`         |
| `signatureProperties` | array object | signature properties | Yes      | see below          |

#### Item Object Properties (for `signatureProperties`)

| Parameter     | Type    | Description       | Required | Example Value |
| :------------ | :------ | :---------------- | :------- | :------------ |
| `imageBase64` | string  | base64 format     | Yes      | `{base64}`    |
| `tampilan`    | string  | visible/invisible | Yes      | `VISIBLE`     |
| `page`        | integer | page number       | Yes      | `1`           |
| `originX`     | float   | coordinate X      | Yes      | `52.6`        |
| `originY`     | float   | coordinate Y      | Yes      | `0.0`         |
| `width`       | float   | width             | Yes      | `10.0`        |
| `height`      | float   | height            | Yes      | `20.5`        |
| `location`    | string  | location          | No       | `null`        |
| `reason`      | string  | reason            | No       | `null`       |
| `contactInfo` | string  | contact info      | No       | `null`        |

#### Usage Example
`Endpoint` = `{{baseUrl}}/api/sign/pdfpassphrase`
#### - Request Header: `-`
#### - Request Body: 
```
{
    "nik": "{{nik}}",
    "passphrase": "000000",
    "signatureProperties": [
        {
            "imageBase64": "{{image_ttd_base64}}",
            "tampilan": "VISIBLE",
            "page": 1,
            "originX": 512.0,
            "originY": 0.0,
            "width": 100.0,
            "height": 75.0,
            "location": "null",
            "reason": "null",
            "contactInfo": "null"
        }
    ],
    "file": [
        "{{pdf_2_kb}}"
    ]
}
```
#### - Response Body :
```
{
    "time": 1407,
    "file": [
        "{{base64}}"
    ]
}
```

### 7. Verify PDF
#### Details
#### - Method = `POST`
#### - Endpoint = `{{baseUrl}}/api/verify/pdf`
#### - Path Parameters: `-`
#### - Request Header Parameters : `-`                                         
#### - Request Body Parameters :

| Parameter        | Type   | Description        | Required | Example Value |
| :--------------- | :----- | :----------------- | :------- | :------------ |
| `file`           | string | file signed base64 | Yes      | `{base64}`    |

#### Usage Example
`Endpoint` = `{{baseUrl}}/api/verify/pdf`
#### - Request Header:`-`
#### - Request Body:
```
{
    "file": "{{pdf_signed_base64}}"
}
```
#### - Response Body :
```
{
    "signatureCount": 1,
    "description": "Dokumen valid, Sertifikat yang digunakan tidak terpercaya",
    "conclusion": "WARNING",
    "signatureInformations": [
        {
            "location": "null",
            "id": "S-F406D0585DAFEA2844F5218977AA614D161C7CF4C761A01D9F96E64A469DD349",
            "fieldName": "esc_1733374452418",
            "digestAlgorithm": null,
            "signerName": "User Development",
            "signatureAlgorithm": null,
            "signatureFormat": "PAdES-BASELINE-LT",
            "ltv": true,
            "certificateTrusted": false,
            "signatureDate": "2024-12-05T04:54:12.000+00:00",
            "certificateDetails": [
                {
                    "id": "C-61F97744B465E9A2C507A4D69E6B5E92646499F5B22E3777BBC61C41705C293E",
                    "signatureAlgoritm": "RSA with SHA256",
                    "keyUsages": [
                        "digitalSignature",
                        "nonRepudiation"
                    ],
                    "notBeforeDate": "2024-10-07T07:21:17.000+00:00",
                    "notAfterDate": "2025-04-05T07:21:16.000+00:00",
                    "issuerName": "C=ID,O=Badan Siber dan Sandi Negara,CN=OSD DEMO",
                    "serialNumber": "55496082911230331795330845070850093360379860982",
                    "commonName": "User Development"
                },
                {
                    "id": "C-755C3FC16A810C6D7C5ABC57AE361E2D96585745FAA34B833A322FECA4066F9A",
                    "signatureAlgoritm": "RSA with SHA256",
                    "keyUsages": [
                        "digitalSignature",
                        "keyCertSign",
                        "crlSign"
                    ],
                    "notBeforeDate": "2018-04-08T17:23:28.000+00:00",
                    "notAfterDate": "2028-04-07T17:23:28.000+00:00",
                    "issuerName": "C=ID,O=Badan Siber dan Sandi Negara,CN=OSD DEMO",
                    "serialNumber": "1077311342475385395",
                    "commonName": "OSD DEMO"
                }
            ],
            "certLevelCode": 0,
            "integrityValid": true,
            "timestampInfomation": {
                "id": "T-2E0922D052C838FEC25F0FD708DAAB0A58499C1DE54EC42EA12FB88C5CB85CC4",
                "signerName": "Timestamp Authority Badan Siber dan Sandi Negara",
                "timestampDate": "2024-12-05T04:54:19.000+00:00"
            },
            "lastSignature": false,
            "reason": "null"
        }
    ]
}
```