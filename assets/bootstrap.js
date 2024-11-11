// assets/bootstrap.js

import './styles/app.css'; // Assuming you have Tailwind CSS included

import { Application } from '@hotwired/stimulus';
import { definitionsFromContext } from '@hotwired/stimulus-webpack-helpers';

const application = Application.start();
const context = require.context('./controllers', true, /.js$/);
application.load(definitionsFromContext(context));
