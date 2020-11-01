function initMap(){
    
    const coords = {
        lat: 19.426245,
        lng: -99.167332
    };
    
    let map = new google.maps.Map(document.getElementById('ubicacion-hotel'),{
        center: coords,
        zoom:15,
    });

    let marker = new google.maps.Marker({
        position: coords,
        map,
        title: 'Nombre hotel'
    });
}

initMap();