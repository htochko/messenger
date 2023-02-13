import React from "react";
import {Image} from "../entitites/Image";

export interface TProps {
    image: Image,
    handleDelete: (image: Image) => void,
}
const ImageItem = ({image, handleDelete}: TProps) => {
    return(<>
        <li className="text-white pt-3">
            <div className="d-flex flex-row">
                <div>
                    <a href={image.url} target="_blank" >
                        <img
                            style={{width: 100, height: 'auto'}}
                            src={image.url}
                            alt={image.originalFilename}
                        />
                    </a>
                </div>
                <div className="pl-2">
                    { image.updatedAt ?
                        (<span>Logo added to photo ${image.updatedAt}</span>):
                        (<span>Preparing the logo. Check back soon.</span>)
                    }
                </div>
                <div className="pl-2">
                    <button title="clear image" onClick={() => handleDelete(image)}
                            className="btn btn-warning font-weight-bold">X
                    </button>
                </div>
            </div>
        </li>
    </>);
}

export {ImageItem}