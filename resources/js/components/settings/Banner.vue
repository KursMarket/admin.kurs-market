<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Настройки баннера</h5>

                    <!-- Horizontal Form -->
                    <form>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">h1</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="form.banner_h1">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <button class="btn btn-outline-info" @click.prevent="$refs.imageUploads.click();">изображение</button>
                            </div>
                            <div class="col-sm-10">
                                <input
                                    type="file"
                                    accept=".jpg, .jpeg, .png"
                                    ref="imageUploads"
                                    @change="imageUploadHandler($event)"
                                    style="display: none" />
                                <div class="preview">
                                    <template v-if="!fileTypeValidationError">
                                        <p v-if="!form.image">Файл не выбран</p>
                                        <ol v-else>
                                            <li>
                                                <p>Название: <strong>{{ form.image.name }}</strong>, размер: <strong>{{ getFileSize(form.image.size) }}</strong></p>
                                                <button class="btn btn-danger" style="cursor: pointer" @click.prevent="removeImage">
                                                    <i class="bi bi-archive-fill"></i>
                                                </button>
                                                <img
                                                    :src="getImageSrc(form.image)"
                                                    :alt="form.image.name"
                                                    width="50"
                                                    height="50"
                                                    style="object-fit: cover"
                                                >

                                            </li>
                                        </ol>
                                    </template>
                                    <p v-else style="color: red">Файл не проходит валидацию</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" @click.prevent="save">Сохранить</button>
                        </div>
                    </form><!-- End Horizontal Form -->

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import API from "../../helpers/api";

export default {
    name: "Banner",
    data: () => ({
        fileTypeValidationError: false,
        form: {
            banner_h1: '',
            image: '',
        }
    }),
    computed: {
        fileTypes() {
            return [
                "image/apng",
                "image/bmp",
                "image/gif",
                "image/jpg",
                "image/jpeg",
                "image/pjpeg",
                "image/png",
                "image/svg+xml",
                "image/tiff",
                "image/webp",
                "image/x-icon"
            ];
        }
    },
    created() {
        this.getBannerSetting();
    },
    methods: {
        imageUploadHandler(e) {
            const curFile = e.target.files;
            this.fileTypeValidationError = false;
            if (curFile.length !== 0) {
                if (this.validFileType(curFile[0])) {
                    this.form.image = curFile[0];
                } else {
                    this.fileTypeValidationError = true;
                }
            }
        },
        getFileSize(number) {
            if (number < 1024) {
                return `${number} bytes`;
            } else if (number >= 1024 && number < 1048576) {
                return `${(number / 1024).toFixed(1)} KB`;
            } else if (number >= 1048576) {
                return `${(number / 1048576).toFixed(1)} MB`;
            }
        },
        getImageSrc(file) {
            if (file instanceof File) return URL.createObjectURL(file);
            return file.url;
        },
        validFileType(file) {
            return this.fileTypes.includes(file.type);
        },
        async save() {
            let fd = new FormData();
            if (!this.form.banner_h1) {
                alert('H1 обязателен для заполнения');
                return;
            } else {
                fd.append('title', this.form.banner_h1)
            }

            if (!this.form.image) {
                alert('Загрузите изображение');
                return;
            } else {
                fd.append('file', this.form.image)
            }


            await API.optionsEndpoint.saveMainBannerOption(fd)
        },
        async getBannerSetting() {
            await API.optionsEndpoint.getBannerSetting()
            .then(response => {
                if (response.data.status) {
                    if (response.data.data.title) {
                        this.form.banner_h1 = response.data.data.title
                    }
                    if (response.data.data.image.url) {
                        this.form.image = response.data.data.image
                    }
                }
            })
        },
        removeImage() {
            this.form.image = '';
            API.optionsEndpoint.removeImage()
        }
    }
}
</script>

<style scoped lang="scss">
    .preview{
        background: #eee;
        margin: 0;
        list-style-type: none;
        border: 1px solid black;
        height: 100%;
        padding: 10px;
        & p{
            margin: 0;
            padding: 0;
        }
    }
    ol {
        margin: 0;
        padding: 0;
        & li {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    }
</style>
