self.addEventListener( 'install' , function( event ) {
    event.waitUntil(
        caches.open('sw-caches').then( function( cached ) { 

            cached.add('./view/home.php');
            cached.add('.index.php');
            cached.add('./assets/js/atlantis.js');
            return cached.add('./assets/css/atlantis.css');
        })
    );
});

self.addEventListener( 'fetch', function ( event ) { 
    event.respondWith(

        caches.match( event.request ).then( function ( response ) {
            return response || fetch(event.request);
        })
    );
})
