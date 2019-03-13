<template>
    <div class="col-xs-12 col-sm-6">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="media">
                            <img src="https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference={!! restaurant.photos !!}&key={{ key }}" class="mr-3" alt="{{ restaurant['name'] }}" width="100">
                            <div class="media-body">
                                <div class="font-weight-bold text-primary text-uppercase mb-1">{{ restaurant['name'] }}</div>
                                <div class="text-xs mb-0 font-weight-bold text-gray-800">{{ restaurant['vicinity'] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href="https://maps.google.com/?q={{ restaurant['geometry']['location']['lat'] }},{{ restaurant['geometry']['location']['lng'] }}" target="_blank"><i class="fas fa-map-marker-alt fa-2x text-gray-300"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['restaurants', 'key'],
    data: function() {
        console.log(this.restaurants);
        console.log(this.key);
        var value = JSON.parse(this.restaurants);
        console.log(value);

        return {
            restaurant: value.map((item) => {
                return {
                    photos: item.photos[0].photo_reference
                };
            })
        };
    },

}
</script>
