const orderBy = (formData,fieldName) => {
    formData.model.orderBy = fieldName;
    formData.model.dir = formData.model.dir == 'desc' ? 'asc' : 'desc';
  }

export default orderBy