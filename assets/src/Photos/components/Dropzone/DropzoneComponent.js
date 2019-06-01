import React, { useCallback } from 'react';
import styled from '@emotion/styled';
import { useDropzone } from 'react-dropzone';


const DropSection = styled.div`
    background-color: #fff;
    padding: 40px;
    border: dotted 3px #ccc;
`;

export const DropzoneComponent = () => {
    const onDrop = useCallback(acceptedFiles => {
        // Do something with the files
    }, []);

    const {getRootProps, getInputProps, isDragActive} = useDropzone({onDrop});

    return (
        <DropSection {...getRootProps()}>
            <input {...getInputProps()} />
            {
                isDragActive ?
                <p>Drop the files here ...</p> :
                <p>Drag 'n' drop some files here, or click to select files</p>
            }
        </DropSection>
    );
};
