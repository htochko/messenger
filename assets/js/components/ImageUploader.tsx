import React from "react";
import Dropzone, {IDropzoneProps} from 'react-dropzone-uploader'


const ImageUploader = () => {
    const getUploadParams: IDropzoneProps['getUploadParams'] = () => ({ url: '/api/images' })


    const handleSubmit: IDropzoneProps['onSubmit'] = (files, allFiles) => {
        console.log(files.map(f => f.meta))
        allFiles.forEach(f => f.remove())
    }
    const handleChangeStatus: IDropzoneProps['onChangeStatus']  = ({ meta, remove }, status) => {
        if (status === 'headers_received') {
            console.info(`${meta.name} uploaded!`)
            remove()
        } else if (status === 'aborted') {
            console.info(`${meta.name}, upload failed...`)
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