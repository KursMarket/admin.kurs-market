<template>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Курсы</label>
    </div>
</template>

<script>
export default {
    name: "CourseSaleSearch"
}
</script>

<style scoped>
.well {
    padding: 9px;
    border-radius: 2px;
    min-height: 20px;
    margin-bottom: 20px;
    background-color: #f5f5f5;
    border: 1px solid #e3e3e3;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
}
.dropdown-menu.active{
    display: block;
    padding: 10px;
    margin: 0;
    width: 80%;
}

.dropdown-menu.active li{
    margin-bottom: 0.6rem;
}

.dropdown-menu.active li a{
    color: #000;
}
.bi-file-minus-fill{
    cursor: pointer;
    margin-right: 0.5rem;
}
</style>
