import React from 'react'
import {ImageList} from  "../components/ImageList";
import {ImageUploader} from "../components/ImageUploader";

const ImagePage = () => {
    return (
        <div>
            <div style={{position:'relative'}}>
                <div className="row no-gutters" style={{boxShadow: '0 3px 7px 1px rgba(0,0,0,0.06)'}}>
                    <div className="col py-5">
                        <h1 className="text-center">Add Logo</h1>
                    </div>
                </div>
                <div className="row no-gutters">
                    <div className="col-xs-12 col-md-6 px-5" style={{backgroundColor: '#659dbd', paddingBottom: '150px'}}>
                        <h2 className="text-center mb-5 pt-5 text-white">Step 1: Upload Photo</h2>
                        <ImageUploader
                            v-on:new-image="onNewUploadedImage"
                        ></ImageUploader>
                    </div>
                    <div className="col-xs-12 col-md-6 px-5" style={{backgroundColor: '#7FB7D7',minHeight: '40rem', paddingBottom: '150px'}}>
                        <h2 className="text-center mb-5 pt-5 text-white">Second: Download Improved Photo</h2>
                        <ImageList
                            v-bind:images="images"
                            v-on:delete-image="onDeleteImage"
                        ></ImageList>
                    </div>
                </div>
                <footer className="footer">
                </footer>
            </div>
        </div>
    )
}

export { ImagePage }