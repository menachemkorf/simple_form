class Form {
  constructor() {
    this.$form = $('#form')
    this.fields = {
      username: this.$form.find('input#username'),
      password: this.$form.find('input#password'),
      message: this.$form.find('textarea#message'),
    }

    this.fileFields = {
      attachment: this.$form.find('input#attachment'),
    }

    this.rules = {
      username: ['required', { max: 50 }, { min: 4 }],
      password: ['required'],
      message: ['required'],
      attachment: ['fileRequired', { fileType: 'image' }, { fileMaxSize: 2 }]
    }
  }

  addEventListeners() {
    // Can make some improvement with this method, some repetitive code.
    for (const field in this.fields) {
      let $field = this.fields[field]
      $field.on('focusout', () => {
        let value = $field.val()
        let message = this.isValid($field, value)
        if(message !== true) {
          $field.addClass('is-invalid')
          $field.next('.invalid-feedback').text(message)
        } else {
          $field.removeClass('is-invalid')
          $field.addClass('is-valid')
        }
      })
    }

    for (const fileField in this.fileFields) {
      let $fileField = this.fileFields[fileField]
      $fileField.on('change', () => {
        let file = $fileField.get(0).files[0]
        let message = this.isValid($fileField, file)
        if(message !== true) {
          $fileField.addClass('is-invalid')
          $fileField.next('.invalid-feedback').text(message)
        } else {
          $fileField.removeClass('is-invalid')
          $fileField.addClass('is-valid')
        }
      })
    }

    this.$form.on('submit', (e) => {
      let hasErrors = false;
      for (const field in this.fields) {
        let $field = this.fields[field]
        let value = $field.val()
        let message = this.isValid($field, value)
        if(message !== true) {
          hasErrors = true;
          $field.addClass('is-invalid')
          $field.next('.invalid-feedback').text(message)
        } else {
          $field.removeClass('is-invalid')
          $field.addClass('is-valid')
        }
      }

      for (const fileField in this.fileFields) {
        let $fileField = this.fileFields[fileField]
        let file = $fileField.get(0).files[0]
        let message = this.isValid($fileField, file)
        if(message !== true) {
          hasErrors = true;
          $fileField.addClass('is-invalid')
          $fileField.next('.invalid-feedback').text(message)
        } else {
          $fileField.removeClass('is-invalid')
          $fileField.addClass('is-valid')
        }
      }

      if(hasErrors) {
        e.preventDefault();
      }
    })
  }

  isValid($field, value) {
    let id = $field.attr('id')
    let fieldRules = this.rules[id]

    for (let i = 0; i < fieldRules.length; i++) {
      const element = fieldRules[i]

      if(typeof element === 'string') {
        if(this[element](value) !== true) {
          return this[element](value)
        }
      } else if(typeof element === 'object') {
        let entry = Object.entries(element)[0]
        let funcName = entry[0]
        let arg = entry[1]
        if(this[funcName](value, arg) !== true) {
          return this[funcName](value, arg)
        }
      }
    }

    return true
  }

  required(val) {
    return val.length > 0 || 'This field is required'
  }

  max(val, num) {
    return val.length < num || `This field is too long, Max charachters allowes are ${num}.`
  }

  min(val, num) {
    return val.length > num || `This field is too short, Min charachters allowes are ${num}.`
  }

  fileRequired(file) {
    return !!file || 'This field is required'
  }

  fileType(file, type) {
    return file.type.includes(type) || `File must be of type ${type}.`
  }

  fileMaxSize(file, size) {
    let uploadSize = file.size / 1024 / 1024; // size in MB
    return uploadSize <= size || `Max file upload size is ${size}MB.`
  }
}

const form = new Form()
form.addEventListeners();