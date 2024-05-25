export function createQueue(tasks, maxNumOfWorkers = 4) {
    var numOfWorkers = 0
    var taskIndex = 0
  
    return new Promise(done => {
      const handleResult = index => result => {
        tasks[index] = result
        numOfWorkers--
        getNextTask()
      }
      const getNextTask = () => {
        if (numOfWorkers < maxNumOfWorkers && taskIndex < tasks.length) {
          tasks[taskIndex]().then(handleResult(taskIndex)).catch(handleResult(taskIndex))
          taskIndex++
          numOfWorkers++
          getNextTask()
        } else if (numOfWorkers === 0 && taskIndex === tasks.length) {
          done(tasks)
        }
      }
      getNextTask()
    })
  }