import { STORAGE_BASE } from '../config';

export const uploadImage = async file => {
  const formData = new FormData();
  formData.append('file', file);

  const res = await fetch(STORAGE_BASE, {
    method: 'POST',
    body: formData,
    redirect: 'follow',
  });

  const data = await res.json();

  return data.file;
};
