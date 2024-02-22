import { BrowserRouter } from "react-router-dom";
import { AuthProvider } from "./providers/AuthProvider";
import { ConfigsProvider } from "./contexts/ConfigsContext";

import MyRoute from "./routes/MyRoute";

function App() {
  return (
    <BrowserRouter>
      {/* <ConfigsProvider> */}
        <AuthProvider>
          <MyRoute />
        </AuthProvider>
      {/* </ConfigsProvider> */}
    </BrowserRouter>
  )
}

export default App
