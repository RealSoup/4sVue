<template>
<main>
    <header id="header" class="bg-info"><Head /></header>
    <main class="container"><router-view /></main>
    <footer id="footer" class="bg-info"><Foot /></footer>
</main>
</template>
<script>
import Head from '@/views/web/layouts/Header.vue';
import Foot from '@/views/web/layouts/Footer.vue';


export default {
    name: 'app',
    components: { Head, Foot },
}

</script>

<style type="text/css">
html, body/*, ul, li, ol, input, img, dl, dd, dt, p, div, h1, h2, h3, h4, h5, h6, form, tr, th, td*/
{ margin:0px; padding:0px; font-family:"나눔고딕","NanumGothic",  "돋움", "굴림","dotum", "Gulim"; color: #333; font-size:16px; line-height:16px;}
#header { margin-bottom:1rem; }
#footer { margin:6rem auto; padding:2rem 0; }
.layout { margin-left:auto; margin-right:auto; max-width:1600px; width:100%; }
ul, ol, li, dt, dd { list-style:none; margin:0px; padding:0px; }
a, a:hover { color:#333; text-decoration:none; }
.cb { clear:both; font-size:0px !important; line-height:0px !important; margin:0px !important; padding:0px !important; height:0px !important; width:0px !important; float:none !important; }
.clear-both:after { content:"&nbsp;"; display:block; clear:both; visibility:hidden; line-height:0; height:0; }
.no_item { border:1px solid #CCC; text-align:center; }
.btn_box { margin-top:1rem; }
.btn_box.btn_right { text-align:right; }
input::placeholder, textarea::placeholder { color:#CCC !important; }



.bd_red { border:1px solid red; }
.bd_blue { border:1px solid blue; }
</style>
