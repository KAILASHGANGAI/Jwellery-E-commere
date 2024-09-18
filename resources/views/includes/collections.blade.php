<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

<style>
     /* Positioning next and previous buttons in the middle of each side */
     .owl-nav {
            position: relative;
        }

        .owl-prev, .owl-next {
            position: absolute;
            top: 50%; /* Vertically center the buttons */
            transform: translateY(-50%);
            background-color: #a8741a; /* Button background color */
            color: #fff;
            border-radius: 50%; /* Make the buttons round */
            padding: 10px;
            font-size: 18px;
            cursor: pointer;
        }

        /* Left side (previous button) */
        .owl-prev {
            left: -30px; /* Adjust the position to be outside the carousel */
        }

        /* Right side (next button) */
        .owl-next {
            right: -30px; /* Adjust the position to be outside the carousel */
        }

        /* Optional: Add hover effects */
        .owl-prev:hover, .owl-next:hover {
            background-color: #ff9800;
        }

        .collection {
            padding: 10px;
        }

        .collection:hover {
            border: 1px solid #a8741a;
        }
        .collection:hover > .product-title {
            color: #a8741a;
        }
</style>

<div class="container my-5">
    <h4 class="main-title text-center py-4">Shop By Collections</h4>
    <div class="owl-carousel owl-theme" id="myallCollection">
        <!-- Static content for testing -->
        <!-- <div class="item"><h4>Static Item 1</h4></div> -->
        <!-- <div class="item"><h4>Static Item 2</h4></div> -->
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
    $(document).ready(function() {
        const childCollectionUrl = '{{ route('childCollections') }}';

        async function fetchCollections() {
            try {
                const response = await fetch(childCollectionUrl);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                console.log(data); // Check the response data
                displayCollections(data);
                initializeOwlCarousel();
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
                alert('Failed to load collections. Please try again later.');
            }
        }

        function displayCollections(data) {
            const collectionRow = document.getElementById('myallCollection');
            data.forEach(coll => {
                const childUrl = `{{ url('collection') }}/${coll.slug}`;
                const ImageIrl = '{{ asset('/') }}'  + coll.file_path;
                const collectionHTML = `
                    <div class="item">
                        <a href="${childUrl}" class="text-decoration-none">
                            <div class="collection">
                                <div class="product-image">
                                    <img src="${ImageIrl}" alt="${coll.name}" class="img-fluid">
                                </div>
                                <h5 class="product-title  text-center">${coll.title}</h5>
                            </div>
                        </a>
                    </div>
                `;
                collectionRow.innerHTML += collectionHTML;
            });
        }

        function initializeOwlCarousel() {
            const owl = $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                // dots: false,
                responsiveClass: true,
                nav: true, // Enable navigation buttons


                responsive: {
                    0: {
                        items: 3,
                        nav: true
                    },
                    600: {
                        items: 4,
                        nav: false
                    },
                    1000: {
                        items: 6,
                        nav: true,
                        loop: false
                    }
                }
            });
            owl.trigger('refresh.owl.carousel'); // Refresh carousel after adding items
        }

        fetchCollections();
    });
</script>
