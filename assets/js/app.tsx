import React from "react";
import { ImagePage } from "./pages/ImagePage";
import { createRoot } from 'react-dom/client';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';

const container = document.getElementById('app');
console.log(container);
const root = createRoot(container); // createRoot(container!) if you use TypeScript
root.render(<ImagePage />);
