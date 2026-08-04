// script.js

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
        closeMenu();
    });
});

// Back to Top Button
const backToTopButton = document.getElementById('back-to-top');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        backToTopButton.style.display = 'block';
    } else {
        backToTopButton.style.display = 'none';
    }
});

backToTopButton.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Scroll Arrow Functionality
const scrollArrow = document.getElementById('scroll-arrow');
const firstSection = document.querySelector('.section');

scrollArrow.addEventListener('click', () => {
    firstSection.scrollIntoView({
        behavior: 'smooth'
    });
});

// Carousel Functionality with Navigation Arrows
let carouselIndex = 1;
const slidesContainer = document.querySelector('.carousel .slides');
const slides = document.querySelectorAll('.carousel .slide');
const indicators = document.querySelectorAll('.carousel-indicators .indicator');
const prevArrow = document.querySelector('.arrow.prev');
const nextArrow = document.querySelector('.arrow.next');
const totalSlides = slides.length;
const beerCampaignIndex = totalSlides - 2;

function updateCarouselCampaignState(index) {
    const campaignIsActive = index === 0 || index === beerCampaignIndex;
    document.querySelector('.hero-banner').classList.toggle('beer-mats-campaign-active', campaignIsActive);
}

function updateCarouselIndicators(index) {
    indicators.forEach(indicator => indicator.classList.remove('active'));
    indicators[(index - 1) % (totalSlides - 2)].classList.add('active');
}

function moveToSlide(index) {
    updateCarouselCampaignState(index);
    slidesContainer.style.transition = 'transform 0.5s ease-in-out';
    slidesContainer.style.transform = `translateX(-${index * 100}%)`;
}

function moveToNextSlide() {
    if (carouselIndex >= totalSlides - 1) {
        carouselIndex = 1;
        slidesContainer.style.transition = 'none';
        slidesContainer.style.transform = `translateX(-${carouselIndex * 100}%)`;
    }
    setTimeout(() => {
        slidesContainer.style.transition = 'transform 0.5s ease-in-out';
        carouselIndex++;
        moveToSlide(carouselIndex);
        updateCarouselIndicators(carouselIndex);
    }, 20);
}

function moveToPrevSlide() {
    if (carouselIndex <= 0) {
        carouselIndex = totalSlides - 2;
        slidesContainer.style.transition = 'none';
        slidesContainer.style.transform = `translateX(-${carouselIndex * 100}%)`;
    }
    setTimeout(() => {
        slidesContainer.style.transition = 'transform 0.5s ease-in-out';
        carouselIndex--;
        moveToSlide(carouselIndex);
        updateCarouselIndicators(carouselIndex);
    }, 20);
}

// Event listener for previous arrow
prevArrow.addEventListener('click', moveToPrevSlide);

// Event listener for next arrow
nextArrow.addEventListener('click', moveToNextSlide);

// Event listeners for indicators
indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => {
        carouselIndex = index + 1;
        moveToSlide(carouselIndex);
        updateCarouselIndicators(carouselIndex);
    });
});

// Automatically cycle through images
setInterval(() => {
    moveToNextSlide();
}, 4500);

// Initial setup
moveToSlide(carouselIndex);
updateCarouselIndicators(carouselIndex);

// Dynamic Content for Products
const productDetails = {
    glassware: { 
                link: "pdfs/glassCatalogue.pdf", 
                button: "DOWNLOAD OUR CATALOGUE", 
                header: "Printed Glassware", 
                image: "images/glassware.jpg",
                icon1: "images/basedindublin.png",
                icon2: "images/fastleadtime.png",
                icon3: "images/lowmoq.png",
                icon4: "images/pantonematch.png",
                icon5: "images/highquality.png",
                icon6: "images/ecofriendly.png", 
                icon7: "images/variety.png",
                text: "We offer a wide and premium range of glassware to perfectly match your brand. From elegant wine glasses to trendy beer glasses, our selection covers all your needs. Explore our catalogue below for <strong>premium glass branding in Ireland</strong>.<br><br>Already have the perfect glass? We can print your custom design on it.<br><br>We supply printed beer glasses to pubs, breweries, distilleries, hotels, and restaurants. Additionally, we can print logos on wine glasses with integrated 170ml measures, allowing your staff to pour with precision without needing to measure.",
                text1: "<strong>BASED IN DUBLIN</strong>",
                text2: "<strong>FAST LEAD TIMES</strong>",
                text3: "<strong>LOW MOQs</strong>",
                text4: "<strong>PANTONE COLOUR MATCH</strong>",
                text5: "<strong>HIGH QUALITY FINISH</strong>",
                text6: "<strong>ECO FRIENDLY</strong>",
                text7: "<strong>IDEAL FOR: </strong>various industries, including hospitality, corporate events and promotional campaigns." 
            },
            bottles: { 
                link: "contact.php#quote-form",
                button: "GET A QUOTE NOW", 
                header: "Printed Glass Bottles", 
                image: "images/bottles.jpg", 
                icon1: "images/basedindublin.png",
                icon2: "images/fastleadtime.png",
                icon3: "images/lowmoq.png",
                icon4: "images/pantonematch.png",
                icon5: "images/highquality.png",
                icon6: "images/ecofriendly.png", 
                icon7: "images/variety.png",
                text: "Showcase your brand and its premium quality by printing directly onto your bottles. We offer customized bottle printing for industries ranging from water dispensers to craft beer, spirits, and dairy products. Whether you need small or large-scale print runs, we provide high-quality finishing from our location in Dublin, Ireland. Our services include high-definition Pantone colour <strong>glass bottle printing</strong>, and we can even print on bottle lids for premium brands.", 
                text1: "<strong>BASED IN DUBLIN</strong>",
                text2: "<strong>FAST LEAD TIMES</strong>",
                text3: "<strong>LOW MOQs</strong>",
                text4: "<strong>PANTONE COLOUR MATCH</strong>",
                text5: "<strong>HIGH QUALITY FINISH: </strong> Premium branding, resistant to washing.",
                text6: "<strong>ECO FRIENDLY</strong>",
                text7: "<strong>IDEAL FOR: </strong>various industries, including Whiskey bottles, Premium wine bottles, Milk bottles, Oil bottles, Vitamin drink bottles." 
            },            
"reusable-cups": { 
    link: "contact.php#quote-form",
    button: "GET A QUOTE NOW", 
    header: "Printed Reusable Cups",
    icon1: "images/basedindublin.png",
    icon2: "images/fastleadtime.png",
    icon3: "images/lowmoq.png",
    icon4: "images/pantonematch.png",
    icon5: "images/highquality.png",
    icon6: "images/ecofriendly.png", 
    icon7: "images/variety.png", 
    image: "images/reusable-cups.jpg", 
    text: "Our <strong>printed reusable travel cups</strong> provide a sustainable branding solution, perfect for corporate gifts, team-building events, and fulfilling environmental responsibility initiatives. Made from eco-friendly materials, these travel cups are available in a wide range of sizes and styles. Simply share your requirements with us, and we’ll find the ideal reusable cup to suit your needs and budget.", 
    text1: "<strong>BASED IN DUBLIN</strong>",
    text2: "<strong>FAST LEAD TIMES</strong>",
    text3: "<strong>LOW MOQs</strong>",
    text4: "<strong>PANTONE COLOUR MATCH</strong>",
    text5: "<strong>HIGH QUALITY FINISH:</strong> Premium brands available!!! (see the brands section below)",
    text6: "<strong>ECO FRIENDLY</strong>",
    text7: "<strong>IDEAL FOR: </strong> Corporate gifts, Brand awareness, Event give-aways. Your brand will be taken wherever people take their branded cups! <br><br> <strong>Available:</strong> Printed Eco friendly water bottles, printed double walled bottles, Printed double wall travel mugs/cups." 
},
plastic: { 
    link: "contact.php#quote-form",
    button: "GET A QUOTE NOW",
    header: "Printed Plastic", 
    image: "images/plastic.jpg",
    icon1: "images/basedindublin.png",
    icon2: "images/fastleadtime.png",
    icon3: "images/lowmoq.png",
    icon4: "images/pantonematch.png",
    icon5: "images/highquality.png",
    icon6: "images/ecofriendly.png", 
    icon7: "images/variety.png", 
    text: "We offer a wide selection of <strong>printed and branded reusable and disposable plastic cups</strong>, perfect for any event or occasion. Our screen-printed RPET cups, available in pint and half-pint sizes, are fully recyclable and can be placed in the green bin after use. We also provide eco-friendly, compostable plastic cups that can be printed and branded to suit your needs.<br><br>For a more sustainable option, our reusable polycarbonate pint glasses are ideal. They can be washed and reused multiple times, reducing single-use plastic, and are recyclable after use.<br><br>Ask us about our <strong>branded festival cups</strong>, available in both pint and half-pint sizes. These durable cups can be washed and reused throughout the event, and make for a great souvenir to take home.", 
    text1: "<strong>BASED IN DUBLIN</strong>",
    text2: "<strong>FAST LEAD TIMES</strong>",
    text3: "<strong>LOW MOQs</strong>",
    text4: "<strong>PANTONE COLOUR MATCH</strong>",
    text5: "<strong>HIGH QUALITY FINISH</strong>",
    text6: "<strong>ECO FRIENDLY</strong>",
    text7: "<strong>IDEAL FOR: </strong>events, festivals, large functions. Great to have as a take-home keepsake." 
},
cosmetics: { 
    link: "contact.php#quote-form",
    button: "GET A QUOTE NOW", 
    header: "Printed Cosmetic Packaging", 
    image: "images/cosmetics_product.jpg",
    icon1: "images/basedindublin.png",
    icon2: "images/fastleadtime.png",
    icon3: "images/lowmoq.png",
    icon4: "images/pantonematch.png",
    icon5: "images/highquality.png",
    icon6: "images/ecofriendly.png", 
    icon7: "images/variety.png",
    text: "Enhance your brand's image with <strong>custom-printed cosmetic containers</strong> and <strong>glass decoration</strong> services, offering a premium, luxurious finish. We provide customized printing on both plastic and glass containers, using pure whites or solid Pantone colours to create a high-end look. Whether you need bottles, jars, or even printed lids, we ensure a cohesive and recognizable design that stands out on the shelf. Paired with our comprehensive print services, we have all your branding needs covered.", 
    text1: "<strong>BASED IN DUBLIN</strong>",
    text2: "<strong>FAST LEAD TIMES</strong>",
    text3: "<strong>LOW MOQs:</strong> We offer short production runs and cosmetic prototypes, ideal for initial product launches.",
    text4: "<strong>PANTONE COLOUR MATCH</strong>",
    text5: "<strong>HIGH QUALITY FINISH</strong>",
    text6: "<strong>ECO FRIENDLY</strong>",
    text7: "<strong>FULL BRANDING PACKAGE: </strong>carrier bags, displays, swag, promo items and much more."
},
jars: { 
    link: "contact.php#quote-form",
    button: "GET A QUOTE NOW", 
    header: "Printed Jars", 
    image: "images/jars.jpg",
    icon1: "images/basedindublin.png",
    icon2: "images/fastleadtime.png",
    icon3: "images/lowmoq.png",
    icon4: "images/pantonematch.png",
    icon5: "images/highquality.png",
    icon6: "images/ecofriendly.png", 
    icon7: "images/variety.png", 
    text: "We specialize in <strong>printing directly onto glass and plastic jars and containers</strong>, perfect for a wide range of artisan food products, from salt and honey to sauces, jams, and preserves. Our high-quality, eco-friendly printing services give your brand a premium look, making your products stand out both on the shelf and at events.", 
    text1: "<strong>BASED IN DUBLIN</strong>",
    text2: "<strong>FAST LEAD TIMES</strong>",
    text3: "<strong>LOW MOQs</strong>",
    text4: "<strong>PANTONE COLOUR MATCH</strong>",
    text5: "<strong>HIGH QUALITY FINISH</strong>",
    text6: "<strong>ECO FRIENDLY</strong>",
    text7: "<strong>IDEAL FOR: </strong>Food products, General storage items, Branded jars for alternative drink containers, Café and event supplies, Outdoor rustic events. <br><br> <strong>Available</strong>: Printed Jars for Cosmetic, foods, fragrance, and beverage markets." 
},
bespoke: { 
    link: "contact.php#quote-form",
    button: "GET A QUOTE NOW", 
    header: "Bespoke Print", 
    image: "images/bespoke.jpg", 
    icon1: "images/basedindublin.png",
    icon2: "images/fastleadtime.png",
    icon3: "images/lowmoq.png",
    icon4: "images/pantonematch.png",
    icon5: "images/highquality.png",
    icon6: "images/ecofriendly.png", 
    icon7: "images/variety.png",
    text: "We specialize in <strong>bespoke glass printing</strong>, offering high-quality, customized solutions for artists, signage, and other glass products. Whether you're looking for decorative prints or functional designs, we provide high-resolution printing with deep, rich white ink or Pantone color options, ensuring a flawless finish.<br><br>From intricate art pieces to professional signage, our advanced printing technology allows for precision and vibrant results on flat glass surfaces. Located in Dublin, we cater to both local and international clients, delivering exceptional craftsmanship with every project.", 
    text1: "<strong>BASED IN DUBLIN</strong>",
    text2: "<strong>FAST LEAD TIMES</strong>",
    text3: "<strong>LOW MOQs</strong>",
    text4: "<strong>PANTONE COLOUR MATCH</strong>",
    text5: "<strong>HIGH QUALITY FINISH</strong>",
    text6: "<strong>ECO FRIENDLY</strong>",
    text7: "<strong>IDEAL FOR: </strong>Printed Trophies, Printed Plates, Custom printed glassware, Printed Decorative items." 
},
    ceramic: { 
        link: "contact.php#quote-form",
        button: "GET A QUOTE NOW", 
        header: "Printed Ceramic", 
        image: "images/ceramic.jpg",
        icon1: "images/basedindublin.png",
        icon2: "images/fastleadtime.png",
        icon3: "images/lowmoq.png",
        icon4: "images/pantonematch.png",
        icon5: "images/highquality.png",
        icon6: "images/ecofriendly.png", 
        icon7: "images/variety.png",
        text: "We can print direct to ceramic mugs, but also printing of general ceramic items such as tiles, art pieces, etc. Our skilled designers work closely with you to create stunning, customized designs that reflect your brand's identity.",  
        text1: "<strong>BASED IN DUBLIN</strong>",
        text2: "<strong>FAST LEAD TIMES</strong>",
        text3: "<strong>LOW MOQs</strong>",
        text4: "<strong>PANTONE COLOUR MATCH</strong>",
        text5: "<strong>HIGH QUALITY FINISH</strong>",
        text6: "<strong>ECO FRIENDLY</strong>",
        text7: "<strong>IDEAL FOR: </strong>Drinking Mugs, Beer Mugs, Tapas Dishes, And more!" 
    },  
};

function showProduct(product) {
    const details = productDetails[product];
    const actionTarget = details.link === "contact.php#quote-form" ? "" : ' target="_blank"';
    const productDetailsDiv = document.getElementById('product-details');
    productDetailsDiv.innerHTML = `
        <div class="product-about-section">
            <img src="${details.image}" alt="${details.header}" class="productimage">
            <div class="product-description">
                <h3><strong>${details.header}</strong></h3>
                <div>
                    <p >${details.text}</p>
                </div>
                <div class="productfeature">
                    <img src="${details.icon1}">
                    <p >${details.text1}</p>
                </div>
                <div class="productfeature">
                    <img src="${details.icon2}">
                    <p >${details.text2}</p>
                </div>
                <div class="productfeature">
                    <img src="${details.icon3}">
                    <p >${details.text3}</p>
                </div>
                <div class="productfeature">
                    <img src="${details.icon4}">
                    <p >${details.text4}</p>
                </div>
                <div class="productfeature">
                    <img src="${details.icon5}">
                    <p >${details.text5}</p>
                </div>
                <div class="productfeature">
                    <img src="${details.icon6}">
                    <p >${details.text6}</p>
                </div>
                <div class="productfeature">
                    <img src="${details.icon7}">
                    <p >${details.text7}</p>
                </div>
                <a href="${details.link}" class="product-button"${actionTarget}>${details.button}</a>
            </div>
        </div>
    `;
    // Set the active button
    document.querySelectorAll('.products-services .button').forEach(button => {
        button.classList.remove('active');
    });
    document.querySelector(`.products-services .button[onclick="showProduct('${product}')"]`).classList.add('active');
}

// Show initial product details
showProduct('glassware');

// Toggle mobile menu
const menuToggle = document.querySelector('.menu-toggle');
const closeMenuButton = document.querySelector('.close-menu');
const navbar = document.querySelector('.navbar');

menuToggle.addEventListener('click', () => {
    navbar.classList.toggle('active');
});

closeMenuButton.addEventListener('click', () => {
    navbar.classList.remove('active');
});

function closeMenu() {
    navbar.classList.remove('active');
}

document.addEventListener('DOMContentLoaded', () => {
    // Header animations for h2 and h3
    const headers = document.querySelectorAll('.section h2, .about-us h3');

    const observerOptions = {
        threshold: 0.1 // Trigger when 10% of the element is in the viewport
    };

    const headerObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-header');
            } else {
                entry.target.classList.remove('animate-header');
            }
        });
    }, observerOptions);

    headers.forEach(header => {
        headerObserver.observe(header);
    });

    // Images in Recent Work section (already implemented)
    const recentWorkImages = document.querySelectorAll('.recent-work .grid img');

    const imageObserverOptions = {
        threshold: 0.1
    };

    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                entry.target.style.setProperty('--animation-delay', `${index * 0.2}s`);
                entry.target.classList.add('animate-recent-work-image');
            } else {
                entry.target.classList.remove('animate-recent-work-image');
            }
        });
    }, imageObserverOptions);

    recentWorkImages.forEach(image => {
        imageObserver.observe(image);
    });

    // About Us section animations
    const aboutUsImages = document.querySelectorAll('.about-us .about-topic img');
    const aboutUsTexts = document.querySelectorAll('.about-us .about-topic div');

    const aboutUsObserverOptions = {
        threshold: 0.1
    };

    const aboutUsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.tagName === 'IMG') {
                    entry.target.classList.add('animate-about-us-image');
                } else {
                    entry.target.classList.add('animate-about-us-text');
                }
            } else {
                if (entry.target.tagName === 'IMG') {
                    entry.target.classList.remove('animate-about-us-image');
                } else {
                    entry.target.classList.remove('animate-about-us-text');
                }
            }
        });
    }, aboutUsObserverOptions);

    aboutUsImages.forEach(image => aboutUsObserver.observe(image));
    aboutUsTexts.forEach(text => aboutUsObserver.observe(text));
        
    // Core Values section animations
    const coreValues = document.querySelectorAll('.core-values .value');

    const coreValuesObserverOptions = {
        threshold: 0.1
    };

    const coreValuesObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                entry.target.style.setProperty('--animation-delay', `${index * 0.2}s`);
                entry.target.classList.add('animate-core-value');
            } else {
                entry.target.classList.remove('animate-core-value');
            }
        });
    }, coreValuesObserverOptions);

    coreValues.forEach(value => {
        coreValuesObserver.observe(value);
    });

    // Support Local section animations
    const supportLocal = document.querySelectorAll('.support-local .value');

    const supportLocalObserverOptions = {
        threshold: 0.1
    };

    const supportLocalObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                entry.target.style.setProperty('--animation-delay', `${index * 0.2}s`);
                entry.target.classList.add('animate-support-local');
            } else {
                entry.target.classList.remove('animate-support-local');
            }
        });
    }, supportLocalObserverOptions);

    supportLocal.forEach(value => {
        supportLocalObserver.observe(value);
    });
});

// Gallery functionality
const galleries = Array.from(document.querySelectorAll('.gallery'));
const totalGalleryImages = galleries[0].children.length;
const imagesPerRow = 4; // Number of images per row
let galleryIndices = [0, 0]; // Separate index for each gallery

// Clone the first set of images for each gallery and append them to create a seamless loop
const cloneImages = () => {
    galleries.forEach(gallery => {
        Array.from(gallery.children).forEach(image => {
            const clone = image.cloneNode(true);
            gallery.appendChild(clone);
        });
    });
};
cloneImages();

function updateGallery(index, gallery) {
    const translateXValue = -(galleryIndices[index] * (100 / imagesPerRow));
    gallery.style.transform = `translateX(${translateXValue}%)`; // Scroll one image at a time
}

function moveGallery(direction) {
    galleries.forEach((gallery, index) => {
        if (direction === 'next') {
            galleryIndices[index]++;
            if (galleryIndices[index] >= totalGalleryImages) {
                galleryIndices[index] = 0;
                gallery.style.transition = 'none';
                gallery.style.transform = `translateX(0)`;
            } else {
                gallery.style.transition = 'transform 1s linear';
                updateGallery(index, gallery);
            }
        } else if (direction === 'prev') {
            galleryIndices[index]--;
            if (galleryIndices[index] < 0) {
                galleryIndices[index] = totalGalleryImages - 1;
                gallery.style.transition = 'none';
                gallery.style.transform = `translateX(${-(galleryIndices[index] * (100 / imagesPerRow))}%)`;
            } else {
                gallery.style.transition = 'transform 1s linear';
                updateGallery(index, gallery);
            }
        }
    });
}

// Automatically scroll the galleries
setInterval(() => {
    moveGallery('next');
}, 3000); // Adjust the interval for slower scrolling

// Event listeners for arrows
document.querySelector('.gallery-prev').addEventListener('click', () => {
    moveGallery('prev');
});
document.querySelector('.gallery-next').addEventListener('click', () => {
    moveGallery('next');
});

// Functionality to open and close the modals
document.addEventListener('DOMContentLoaded', function() {
    // Get all the buttons that trigger modals
    const learnMoreButtons = document.querySelectorAll('.learn-more-btn');

    // Add event listeners to each button to open the appropriate modal
    learnMoreButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'block';
            }
        });
    });

    // Get all the close buttons within the modals
    const closeButtons = document.querySelectorAll('.industry-close-btn');

    // Add event listeners to close buttons to hide the modal
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.industry-modal');
            modal.style.display = 'none';
        });
    });

    // Close the modal if the user clicks outside the modal content
    window.addEventListener('click', function(event) {
        const modals = document.querySelectorAll('.industry-modal');
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
});
