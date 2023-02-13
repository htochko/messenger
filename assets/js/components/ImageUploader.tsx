import React from "react";
import Dropzone, {IDropzoneProps} from 'react-dropzone-uploader';
import {Image as ImageItem} from "../entitites/Image";

export interface TProps {
    handleUpload: (imageToAdd: ImageItem) => void
}
const ImageUploader = ({handleUpload}: TProps) => {
    const getUploadParams: IDropzoneProps['getUploadParams'] = () => ({ url: '/api/images' })


    const handleSubmit: IDropzoneProps['onSubmit'] = (files, allFiles) => {
        console.log(files.map(f => f.meta))
        allFiles.forEach(f => f.remove())
    }

    const handleChangeStatus: IDropzoneProps['onChangeStatus']  = ({ meta, remove , file, xhr}, status) => {
        if (status === 'headers_received') {
            console.info(`${meta.name} uploaded!`)
            remove()
        } else if (status === 'aborted') {
            console.info(`${meta.name}, upload failed...`)
        }
        if (status === 'done'){
            let response = JSON.parse(xhr.response);
            handleUpload(response as ImageItem);
        }
    }

    return(<Dropzone
        getUploadParams={getUploadParams}
        onChangeStatus={handleChangeStatus}
        onSubmit={handleSubmit}
        maxFiles={1}
        multiple={false}
        canCancel={false}
        inputContent="Drop A File"
        styles={{
            dropzone: { width: 400, height: 200 },
            dropzoneActive: { borderColor: 'green' },
        }}
    />)
}

export { ImageUploader }