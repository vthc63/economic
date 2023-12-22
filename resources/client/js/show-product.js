$(document).ready(function(){
    $(document).on('click', '#filter-price', function(){
        let url = $('#filter-price').attr('url') + "";
        let minPrice = $('#min-price').val()
        let maxPrice = $('#max-price').val()
        if(url.search("[\\[\\]?*+|{}\\\\()@.\n\r]") >= 0){
            if (url.search('min_price=') >= 0) {
                let minPriceOld = url.split('min_price')[1].split('=')[1].split('&')[0]
                url = url.replace(minPriceOld, minPrice)
            } else {
                url += `&min_price=${minPrice}`
            }
            if (url.search('max_price=') >= 0) {
                let maxPriceOld = url.split('max_price')[1].split('=')[1].split('&')[0]
                url = url.replace(maxPriceOld, maxPrice)
            } else {
                url += `&max_price=${maxPrice}`
            }
        } else {
            url += `?min_price=${minPrice}&max_price=${maxPrice}`
        }
        window.location.href = url;
    })
});