'use strict';
const { Model } = require('sequelize');

module.exports = (sequelize, DataTypes) => {
  class Task extends Model {
    /**
     * Helper method for defining associations.
     * This method is not a part of Sequelize lifecycle.
     * The `models/index` file will call this method automatically.
     */
    static associate(models) {
      // define association here
      models.task.belongsTo(models.user)
    }
  }
  Task.init({
    description: DataTypes.STRING
  }, {
    sequelize,
    modelName: 'task',
  });
  return Task;
};