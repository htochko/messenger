import React, {useEffect, useState} from 'react'
import {ImageUploader} from "../components/ImageUploader";
import {Image} from "../entitites/Image";
import axios from "axios";
import {ImageItem} from "../components/ImageItem";
const ImagePage = () => {
    const [images, setImages] = useState<Image[]>([]);
    useEffect(() => {
        axios
            .get('/api/images')
            .then(response => (setImages(response.data.items)));

    }, []);
    const handleDelete = (imageToDelete: Image) => {
        axios
            .delete(imageToDelete['@id'])
            .then(() => {
                setImages(images.filter(image => imageToDelete.id !== image.id));
            })
    }
    const handleUpload = (imageToAdd: Image) => {
        if (images.find(image => imageToAdd.id === image.id)) {
            return;
        }
        images.splice(0, 0, imageToAdd)
        setImages([...images]);
    }

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
                        <ImageUploader handleUpload={handleUpload}
                        ></ImageUploader>
                    </div>
                    <div className="col-xs-12 col-md-6 px-5" style={{backgroundColor: '#7FB7D7',minHeight: '40rem', paddingBottom: '150px'}}>
                       <h2 className="text-center mb-5 pt-5 text-white">Second: Download Improved Photo</h2>
                        <>
                            {images.map(image => (<ImageItem image={image} handleDelete={handleDelete} key={image.id} />)) }
                        </>
                    </div>
                </div>
                <footer className="footer">
                </footer>
            </div>
        </div>
    )
}

export { ImagePage }