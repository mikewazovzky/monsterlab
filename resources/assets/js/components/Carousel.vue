<template>
    <div class="carousel fade" data-ride="carousel" id="featured">
        <ol class="carousel-indicators"></ol>
        <div class="carousel-inner fullheight" ref="images">
            <slot>
                <!--
                Carousel images should be placed inside the slot.
                Images should be wrapped by a <div class="item">
                <div class="item"><img src="/images/carousel-image.jpg"></div>
                -->
            </slot>
        </div>
        <a class="left carousel-control" href="#featured" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#featured" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
</template>

<script>
export default {
    computed: {
        imagesCount() {
            return this.$refs.images.children.length;
        }
    },

    mounted() {
        // Set random image as active
        const activeImage = this.setActiveImage();
        // Set carousel height equal to window height
        this.setHeight();
        // Adjust carousel height on window resize
        $(window).resize(() => this.setHeight());
        // Replace images inside carousel with a background image
        $('#featured .item img').each(function () {
            const imgSrc = $(this).attr('src');
            $(this).parent().css({ 'background-image': `url(${imgSrc})` });
            $(this).remove();
        });
        // Generate carousel indicators
        this.generateIndicators(activeImage);
        // Set bootstrap carousel options
        $('.carousel').carousel({
            pause: false
        });
    },

    methods: {
        // Set active to random image
        setActiveImage() {
            const index = Math.floor(Math.random() * this.imagesCount);
            $('#featured .item').eq(index).addClass('active');
            return index;
        },

        // Set carousel images height equal to window height
        setHeight() {
            const windowHeight = window.innerHeight;
            $('.fullheight').css('height', windowHeight);
        },

        // Generate carousel indicators
        generateIndicators(active) {
            for (let i = 0; i < this.imagesCount; i++) {
                let insertText = '<li data-target="#featured" data-slide-to="' + i + '"';
                if (i === active) {
                    insertText += ' class="active" ';
                }
                insertText += '></li>';
                $('#featured ol').append(insertText);
            }
        }
    }
}
</script>

<style>
.carousel.fade {
  opacity: 1;
}

.carousel.fade .item {
  transition: opacity ease-out .7s;
  left: 0;
  opacity: 0;
  top: 0;
  position: absolute;
  width: 100%;
  display: block;
}

.carousel.fade .item:first-child {
  top: auto;
  opacity: 0;
  position: relative;
}

.carousel.fade .item.active {
  opacity: 1;
}

.carousel-control {
  opacity: 0;
}

.carousel-control.right,
.carousel-control.left {
  background-image: none;
}

#featured .item {
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  width: 100%;
  height: 100%;
}

</style>
