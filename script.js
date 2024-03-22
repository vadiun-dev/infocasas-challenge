const axios = require('axios');

const URL = 'https://graph.infocasas.com.uy/graphql';

const property_id = process.argv[2];

//Proccess output 
function proccessResponse(response) {

    if (response.data.data.searchFast.data.length > 1) {
        console.log("price not found for id ", property_id);
        return;
    }

    const data = response.data.data.searchFast.data[0];

    console.log(data.price + ' ' + data.currency);

}

// Build request body 
const requestBody = {
    operationName: "ResultsGird_v2",
    variables: {
        rows: 21,
        params: {
            page: 1,
            order: 2,
            operation_type_id: 1,
            estate_id: 10,
            currencyID: 1,
            property_id: parseInt(property_id),
            m2Currency: 2
        },
        page: 1,
        source: 0
    },
    query: "query ResultsGird_v2($rows: Int!, $params: SearchParamsInput!, $page: Int, $source: Int) {\n  searchFast(params: $params, first: $rows, page: $page, source: $source)\n}\n"
};

axios.post(URL, requestBody, {
    headers: {
        'Content-Type': 'application/json',
        'x-origin': 'www.infocasas.com.uy',
        'Origin': 'https://www.infocasas.com.uy'
    }
})
.then(proccessResponse)
.catch(error => console.error('Error al realizar la solicitud HTTP:', error));

